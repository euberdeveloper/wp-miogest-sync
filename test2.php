<?php

require_once('../../../wp-load.php');
require_once('../../../wp-admin/includes/upgrade.php');

class Syncer
{
  private static $allowed_addrs = ['77.39.210.53', '127.0.0.1', '151.84.171.207'];
  private static string $static_annunci_table = 'miogest_synced_annunci';

  private string $base_post_url;
  private array $upload_dir;
  private string $now;
  private array $post_metadata_keys;
  private array $langs;
  private array $floors;

  private array $annunci;
  private array $categorie;
  private array $stati_immobili;

  private string $annunci_table;
  private string $posts_table;
  private string $postmeta_table;
  private string $term_relationships_table;
  private string $icl_translations_table;
  public array $miogest_sync_annunci_ids;

  private function getFotosFromAnnuncio(array $annuncio): ?string
  {
    $fotos_str = null;

    if (array_key_exists('Foto', $annuncio) && is_array($annuncio['Foto'])) {
      $fotos = array_map(function ($foto) {
        return end(explode('/', $foto));
      }, $annuncio['Foto']);
      $fotos_str = implode(',', $fotos);
    }

    return $fotos_str;
  }

  private function getPostMeta(array $annuncio, string $lang): array
  {
    return [
      'locality' => strtolower(str_replace(' ', '', $annuncio['Comune'])),
      'property_gallery' => $this->getFotosFromAnnuncio($annuncio),
      'property_price' => !is_array($annuncio['Prezzo']) ? $annuncio['Prezzo'] : '',
      'built_in' => !is_array($annuncio['Anno']) ? $annuncio['Anno'] : '',
      'classe_energetica' => !is_array($annuncio['Classe']) ? $annuncio['Classe'] : '',
      'stato_immobile' => !is_array($annuncio['Scheda_StatoImmobile']) 
        ? $this->stati_immobili['valori'][$annuncio['Scheda_StatoImmobile']][$lang]
        : '',
      'piano' => !is_array($annuncio['Piano']) ? $this->floors[$lang][$annuncio['Piano']] : '',
      'codice' => !is_array($annuncio['Codice']) ? $annuncio['Codice'] : '',
      'property_size' => !is_array($annuncio['Mq']) ? $annuncio['Mq'] : '',
      'mq_sotto' => !is_array($annuncio['Mq']) ? $annuncio['Mq'] : '',
      'property_agent' => '290',
      'property_featured' => '1' // Note: in old code it was 1 if annuncio_index < 4
    ];
  }

  private function insertAnnuncio(int $annuncio_id, int $post_id, string $lang): void
  {
    global $wpdb;

    $wpdb->insert(
      $this->annunci_table,
      [
        'post_id' => $post_id,
        'type' => '1',
        'annuncio_id' => $annuncio_id,
        'lang' => $lang
      ]
    );
  }

  private function insertPost(string $descrizione, string $titolo, string $name, array $meta_info): int
  {
    $post = [
      'post_content' => $descrizione,
      'post_title' => $titolo,
      'post_name' => $name,
      'post_type' => 'property',
      'post_date' => $this->now,
      'post_date_gmt' => $this->now,
      'post_modified' => $this->now,
      'post_modified_gmt' => $this->now,
      'comment_status' => 'closed',
      'post_status' => 'publish',
      'ping_status' => 'closed',
      'meta_input' => $meta_info
    ];

    $id = wp_insert_post($post);
    wp_update_post(['ID' => $id, 'guid' => $this->base_post_url . $id]);

    return $id;
  }

  public function __construct()
  {
    global $table_prefix;

    $this->base_post_url = get_site_url() . '/prova/?post_type=property&p=';
    $this->now = current_time('mysql', false);
    $this->upload_dir = wp_upload_dir();
    $this->post_metadata_keys = ["_edit_lock", "_edit_last", "property_address", "property_lat", "property_lng", "street_number", "route", "neighborhood", "locality", "administrative_area_level_1", "postal_code", "property_price", "property_price_label", "property_taxes", "property_hoa_dues", "property_beds", "property_baths", "property_size", "internet", "garage", "elevator", "air_conditioning", "pool", "dishwasher", "fireplace", "balcony", "built_in", "lot_width", "lot_depth", "stories", "room_count", "parking_spaces", "property_video", "property_virtual_tour", "property_agent", "property_gallery", "property_floor_plans", "property_calc", "property_featured", "spese_condominiali", "classe_energetica", "stato_immobile", "mq_sotto", "piano", "codice"];
    $this->langs = ["it", "en", 'de'];
    $this->floors = [
      'it' => ['Piano terra', 'Primo piano', 'Secondo piano', 'Terzo piano', 'Quarto piano', 'Quinto piano'],
      'en' => ['Ground Floor', 'First Floor', 'Second Floor', 'Third Floor', 'Fourth Floor', 'Fifth Floor'],
      'de' => ['Erdgeschoss', 'Erster Stock', 'Zweiter Stock', 'Dritter Stock', 'Vierter Stock', 'Fünfter Stock']
    ];

    $this->annunci_table = $table_prefix . Syncer::$static_annunci_table;
    $this->posts_table = $table_prefix . 'posts';
    $this->postmeta_table = $table_prefix . 'postmeta';
    $this->term_relationships_table = $table_prefix . 'term_relationships';
    $this->icl_translations_table = $table_prefix . 'icl_translations';
  }

  public function checkRemoteAddress(): void
  {
    $remote_addr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
    if (!in_array($remote_addr, Syncer::$allowed_addrs)) {
      die("Remote address $remote_addr not allowed");
    }
  }

  public function fetchRemoteData(): void
  {
    $urlAnnunci = "http://partner.miogest.com/agenzie/gardahomeproject.xml";
    $xmlAnnunci = simplexml_load_file($urlAnnunci);
    $jsonAnnunci = json_encode($xmlAnnunci);
    $annunci = json_decode($jsonAnnunci, true);
    $this->annunci = $annunci['Annuncio'];

    $urlCategorie = "http://www.miogest.com/apps/revo.aspx?tipo=categorie";
    $xmlCategorie = simplexml_load_file($urlCategorie);
    $jsonCategorie = json_encode($xmlCategorie);
    $categorie = json_decode($jsonCategorie, true);
    $this->categorie = $categorie['cat'];

    $urlSchedeImmobili = "http://www.miogest.com/apps/revo.aspx?tipo=schede";
    $xmlSchedeImmobili = simplexml_load_file($urlSchedeImmobili);
    $jsonSchedeImmobili = json_encode($xmlSchedeImmobili);
    $schedeImmobili = json_decode($jsonSchedeImmobili, true)['scheda'];
    $schedaStatiImmobili = array_values(
      array_filter($schedeImmobili, function ($scheda) {
        return $scheda['id'] == '57';
      })
    )[0];
    $stati_immobili = [
      'nomi' => [
        'it' => $schedaStatiImmobili['nome'],
        'en' => $schedaStatiImmobili['nome_en'],
        'de' => $schedaStatiImmobili['nome_de']
      ],
      'valori' => []
    ];
    $stati_immobili_valori = $schedaStatiImmobili['valori']['valore'];
    for ($i = 0; $i < count($stati_immobili_valori); $i++) {
      $value = $stati_immobili_valori[$i];
      $stati_immobili['valori'][$value] = [
        'it' => $schedaStatiImmobili['valori']['valore'][$i],
        'en' => $schedaStatiImmobili['valori_en']['valore'][$i],
        'de' => $schedaStatiImmobili['valori_de']['valore'][$i]
      ];
    }
    $this->stati_immobili = $stati_immobili;
  }

  public function getAnnunciIds(): void
  {
    global $wpdb;

    $result = $wpdb->get_results("
      SELECT * 
      FROM $this->annunci_table
    ");

    $this->miogest_sync_annunci_ids = array_map(function ($item) {
      return $item->post_id;
    }, $result);
  }

  public function deleteOldAnnunci(): void
  {
    global $wpdb;

    $annunci_count = count($this->miogest_sync_annunci_ids);
    $placeholders = array_fill(0, $annunci_count, '%d');
    $format = implode(', ', $placeholders);

    function getQuery(string $table, string $prop, string $format): string
    {
      return "
        DELETE FROM $table
        WHERE $prop IN ($format)
      ";
    }

    $queries = [
      getQuery($this->annunci_table, 'post_id', $format),
      getQuery($this->posts_table, 'ID', $format),
      getQuery($this->postmeta_table, 'post_id', $format),
      getQuery($this->term_relationships_table, 'object_id', $format),
      getQuery($this->icl_translations_table, 'element_id', $format)
    ];

    foreach ($queries as $query) {
      $wpdb->query($wpdb->prepare($query, $this->miogest_sync_annunci_ids));
    }
  }

  public function insertNewAnnunci(): void
  {
    foreach ($this->annunci as $annuncio) {
      $id = $annuncio['AnnuncioId'];

      // If the description is missing, let it as a default string
      $default_descrizione_it = 'Descrizione mancante';
      $default_descrizione_en = 'Description missing';
      $default_descrizione_de = 'Fehlende Beschreibung';

      $descrizione_it = !is_array($annuncio['Descrizione']) ? $annuncio['Descrizione'] : $default_descrizione_it;
      // If it is missing in this language, try the Italian one or use the default for that language
      $descrizione_en = !is_array($annuncio['Descrizione_En'])
        ? $annuncio['Descrizione_En']
        : ($descrizione_it != $default_descrizione_it ? $descrizione_it : $default_descrizione_en);
      // If it is missing in this language, try the Italian one or use the default for that language
      $descrizione_de = !is_array($annuncio['Descrizione_De'])
        ? $annuncio['Descrizione_De']
        : ($descrizione_it != $default_descrizione_it ? $descrizione_it : $default_descrizione_de);

      // If the title is missing and there is no default, put the id with the national prefix
      $titolo_it = !is_array($annuncio['Titolo']) ? $annuncio['Titolo'] : $id . '_IT';
      $titolo_en = !is_array($annuncio['Titolo_En'])
        ? $annuncio['Titolo_En']
        : ($titolo_it != $id . '_IT' ? $titolo_it : $id . '_EN');
      $titolo_de = !is_array($annuncio['Titolo_De'])
        ? $annuncio['Titolo_De']
        : ($titolo_it != $id . '_IT' ? $titolo_it : $id . '_DE');

      // The name is the titolo with lowercase and underscores
      $name_it = strtolower(str_replace(' ', '_', $titolo_it));
      $name_en = strtolower(str_replace(' ', '_', $titolo_en));
      $name_de = strtolower(str_replace(' ', '_', $titolo_de));

      // Add metas
      $meta_info_it = $this->getPostMeta($annuncio, 'it');
      $meta_info_en = $this->getPostMeta($annuncio, 'en');
      $meta_info_de = $this->getPostMeta($annuncio, 'de');

      // Inserts the posts
      $post_id_it = $this->insertPost($descrizione_it, $titolo_it, $name_it, $meta_info_it);
      $post_id_en = $this->insertPost($descrizione_en, $titolo_en, $name_en, $meta_info_en);
      $post_id_de = $this->insertPost($descrizione_de, $titolo_de, $name_de, $meta_info_de);

      // Insert the annunci in the list
      $this->insertAnnuncio($id, $post_id_it, 'it');
      $this->insertAnnuncio($id, $post_id_en, 'en');
      $this->insertAnnuncio($id, $post_id_de, 'de');
    }
  }
}

$syncer = new Syncer();
$syncer->checkRemoteAddress();
$syncer->fetchRemoteData();
$syncer->getAnnunciIds();
$syncer->deleteOldAnnunci();
$syncer->insertNewAnnunci();


// Load dependencies


// Check if the remote address is allowed
// $ARR2 = array_fill(0, 44, '');



//   $maxtrid = 1 + $wpdb->get_var("SELECT MAX(trid) FROM 85OCfh1_icl_translations");
//   //Connect translations IT

//   $wpdb->insert(
//     '85OCfh1_icl_translations',
//     array(
//       'element_type' => "post_property",
//       'element_id'      => $record_id,
//       'trid'      => $maxtrid,
//       'language_code'      => 'it',
//       'source_language_code'      => 'it'
//     )
//   );

//   $record_id_trad_it = $wpdb->insert_id;

//   //Connect translations EN

//   $wpdb->insert(
//     '85OCfh1_icl_translations',
//     array(
//       'element_type' => "post_property",
//       'element_id'      => $record_id_en,
//       'trid'      => $maxtrid,
//       'language_code'      => 'en',
//       'source_language_code'      => 'it'
//     )
//   );

//   $record_id_trad_en = $wpdb->insert_id;

//   //Connect translations DE

//   $wpdb->insert(
//     '85OCfh1_icl_translations',
//     array(
//       'element_type' => "post_property",
//       'element_id'      => $record_id_de,
//       'trid'      => $maxtrid,
//       'language_code'      => 'de',
//       'source_language_code'      => 'it'
//     )
//   );

//   $record_id_trad_de = $wpdb->insert_id;



//   //RELATIONSHIP Details about the post (publish, post category, ..)

//   //ARRAYS FOR category
//   $arr_cat_miogest = array(17, 18, 25, 26, 28, 119, 50, 30, 32, 87, 44, 46, 91, 127, 117, 48, 84, 34, 105, 123, 125, 83, 95, 33, 93, 97, 40, 41, 42, 85, 99, 36, 82, 81, 86, 1);




//   for ($s = 0; $s < count($ARR_lang); $s++) {
//     if ($s == 0)
//       $r = $record_id;
//     else if ($s == 1)
//       $r = $record_id_en;
//     else if ($s == 2)
//       $r = $record_id_de;


//     if (array_key_exists('Categoria', $array['Annuncio'][$i])) {
//       if (is_array($array['Annuncio'][$i]['Categoria'])) {
//         for ($y = 0; $y < count($array['Annuncio'][$i]['Categoria']); $y++) {
//           $key = 21 + intval(array_search($array['Annuncio'][$i]['Categoria'][$y], $arr_cat_miogest));
//           $wpdb->insert(
//             '85OCfh1_term_relationships',
//             array(
//               'object_id' => $r,
//               'term_taxonomy_id' => $key,
//               'term_order' =>  0
//             )
//           );
//           echo "<br>" . $array['Annuncio'][$i]['Codice'] . " -> " . $array['Annuncio'][$i]['Categoria'][$y] .  " | " . $key . " | " . array_search($array['Annuncio'][$i]['Categoria'][$y], $arr_cat_miogest);
//         }
//       } else {
//         $key = 21 + intval(array_search($array['Annuncio'][$i]['Categoria'], $arr_cat_miogest));
//         $wpdb->insert(
//           '85OCfh1_term_relationships',
//           array(
//             'object_id' => $r,
//             'term_taxonomy_id' => $key,
//             'term_order' =>  0
//           )
//         );
//         echo "<br>" . $array['Annuncio'][$i]['Codice'] . " -> " . $array['Annuncio'][$i]['Categoria'] .  " | " . $key . " | " . array_search($array['Annuncio'][$i]['Categoria'], $arr_cat_miogest);
//       }
//     }

//     $wpdb->insert(
//       '85OCfh1_term_relationships',
//       array(
//         'object_id' => $r,
//         'term_taxonomy_id' => 11,
//         'term_order' =>  0
//       )
//     );
//   }

//   for ($s = 0; $s < count($ARR_lang); $s++) {
//     if ($s == 0)
//       $r = $record_id;
//     else if ($s == 1)
//       $r = $record_id_en;
//     else if ($s == 2)
//       $r = $record_id_de;

//     //POSTMETA Price and other details about property
//     $ARR2[8] = str_replace(' ', '', strtolower($array['Annuncio'][$i]['Comune']));
//     $ARR2[35] = $img_str;
//     if (!is_array($array['Annuncio'][$i]['Prezzo']))
//       $ARR2[11] = $array['Annuncio'][$i]['Prezzo'];
//     if (!is_array($array['Annuncio'][$i]['Anno']))
//       $ARR2[26] = $array['Annuncio'][$i]['Anno'];
//     /*if(!is_array($array['Annuncio'][$i]['PostiAuto']))
//        $ARR2[31] = $array['Annuncio'][$i]['PostiAuto'];*/
//     if (!is_array($array['Annuncio'][$i]['Classe']))
//       $ARR2[40] = $array['Annuncio'][$i]['Classe'];

//     $stringStat = "";
//     if (!is_array($array['Annuncio'][$i]['Scheda_StatoImmobile'])) {

//       if ($s != 0) {

//         for ($t = 0; $t < count($statoAbit); $t++) {

//           if ($statoAbit[$t] == $array['Annuncio'][$i]['Scheda_StatoImmobile']) {
//             if ($s == 1)
//               $stringStat = $statoAbitEN[$t];
//             else
//               $stringStat = $statoAbitDE[$t];

//             //echo '<br> Stato ab: ' . $stringStat . '  ' . $array['Annuncio'][$i]['Scheda_StatoImmobile']. '<br>';
//             //print_r($arrayStato['scheda'][$o]['valori'][$t]);
//           }
//         }
//         $ARR2[41] = $stringStat;
//       } else {
//         $ARR2[41] = $array['Annuncio'][$i]['Scheda_StatoImmobile'];
//       }
//     }

//     /*if(!is_array($array['Annuncio'][$i]['Piano']))
//        $ARR2[43] = $array['Annuncio'][$i]['Piano'];*/
//     if (!is_array($array['Annuncio'][$i]['Piano'])) {
//       $stringPiano = "";
//       $piano = intval($array['Annuncio'][$i]['Piano']);
//       if ($s == 0)
//         $stringPiano = $PIANI_IT[$piano];
//       else if ($s == 1)
//         $stringPiano = $PIANI_EN[$piano];
//       else if ($s == 2)
//         $stringPiano = $PIANI_DE[$piano];
//       $ARR2[43] = $stringPiano;
//       //print_r($stringPiano);
//       //echo "<br>Piano " . $stringPiano . " | " . $piano . " | " . $s . "<br>";
//       //print_r($PIANO_IT);

//     } else {
//       $ARR2[43] = intval($array['Annuncio'][$i]['Piano']);
//     }

//     if (!is_array($array['Annuncio'][$i]['Codice']))
//       $ARR2[44] = $array['Annuncio'][$i]['Codice'];
//     if (!is_array($array['Annuncio'][$i]['Mq'])) {
//       $ARR2[17] = $array['Annuncio'][$i]['Mq'];
//       $ARR2[42] = $array['Annuncio'][$i]['Mq'];
//     }

//     //AGENT
//     $ARR2[34] = '290';
//     //FEATURED
//     if ($i < 4)
//       $ARR2[38] = '1';


//     /*
//      $stringTip="";
//      if(!is_array($array['Annuncio'][$i]['Categoria'])){		
//        for($y=0; $y<count($arrayCat['cat']); $y++){
//          if( $arrayCat['cat'][$y]['id'] == $array['Annuncio'][$i]['Categoria'] ){
//            if($s==0)
//              $stringTip=$arrayCat['cat'][$i]['nome'];
//            else if($s==1)
//              $stringTip=$arrayCat['cat'][$i]['nome_en'];
//            else if($s==2)
//              $stringTip=$arrayCat['cat'][$i]['nome_de'];
//          }
//        }	
//      } else {
//        echo "<br>Conteggio: " . count($array['Annuncio'][$i]['Categoria']) . "<br>";
//        for($u=0; $u<count($array['Annuncio'][$i]['Categoria']); $u++){
//          print_r( $array['Annuncio'][$i]['Categoria'][$u] ); echo " ";
//          for($y=0; $y<count($arrayCat['cat']); $y++){
//            if( $arrayCat['cat'][$y]['id'] == $array['Annuncio'][$i]['Categoria'][$u] ){
//              if($u==0){
//                if($s==0)
//                  $stringTip=$arrayCat['cat'][$y]['nome'];
//                else if($s==1)
//                  $stringTip=$arrayCat['cat'][$y]['nome_en'];
//                else if($s==2)
//                  $stringTip=$arrayCat['cat'][$y]['nome_de'];
//              } else {
//                if($s==0)
//                  $stringTip=$stringTip . " | " . $arrayCat['cat'][$y]['nome'];
//                else if($s==1)
//                  $stringTip=$stringTip . " | " . $arrayCat['cat'][$y]['nome_en'];
//                else if($s==2)
//                  $stringTip=$stringTip . " | " . $arrayCat['cat'][$y]['nome_de'];
//              }
//            }
//          }
//        }
//      }
//      //echo "Tipo: " . $stringTip . "<br>";
//      $ARR2[42] = $stringTip;*/



//     for ($x = 0; $x < count($ARR2); $x++) {

//       if ($x == 35)
//         print_r($ARR2[$x]);

//       $wpdb->insert(
//         '85OCfh1_postmeta',
//         array(
//           'post_id' => $r,
//           'meta_key' => $ARR1[$x],
//           'meta_value' => $ARR2[$x]
//         )
//       );
//     }
//   }



//   /*

//    85OCfh1_posts

//      (285, 1, '2021-04-21 17:03:00', '2021-04-21 15:03:00', 'Prova', 'Test', '', 'publish', 'open', 'closed', '', 'test', '', '', '2021-04-21 17:03:09', '2021-04-21 15:03:09', '', 0, 'https://gardahomeproject.it/prova/?post_type=property&#038;p=285', 0, 'property', '', 0); */
//   echo "<br>__________________________<br>";
// }



// /* property NOT NECESSARY


// //Populate the translation_status table EN

// $wpdb->insert( 
//  '85OCfh1_icl_translation_status', 
//  array( 
//    'translation_id'    => $record_id_trad_en,
//    'status'     => 9,
//    'translator_id'    => 0,
//    'needs_update' => 0,
//    'batch_id'      => 0,
//    'links_fixed'      => 0,
//    'tp_revision'      => 1,
//    'timestamp'      => $now
//  )
// );

// //Populate the translation_status table DE

// $wpdb->insert( 
//  '85OCfh1_icl_translation_status', 
//  array( 
//    'translation_id'    => $record_id_trad_de,
//    'status'     => 9,
//    'translator_id'    => 0,
//    'needs_update' => 0,
//    'batch_id'      => 0,
//    'links_fixed'      => 0,
//    'tp_revision'      => 1,
//    'timestamp'      => $now
//  )
// );

// */
