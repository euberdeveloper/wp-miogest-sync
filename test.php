<?php

$remote = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : '127.0.0.1';
if( $remote == '77.39.210.53' || $remote == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '151.84.171.207'){
 //echo "ok";
 require( '../../../wp-load.php' );
 require_once('../../../wp-admin/includes/upgrade.php' );
 $upload_dir = wp_upload_dir();

 $now = current_time('mysql', false);
 $base_url = "https://gardahomeproject.it/prova/?post_type=property&p=";


 //array init for postmeta data
 $ARR1 = array("_edit_lock", "_edit_last", "property_address", "property_lat", "property_lng", "street_number", "route", "neighborhood", "locality", "administrative_area_level_1", "postal_code", "property_price", "property_price_label", "property_taxes", "property_hoa_dues", "property_beds", "property_baths", "property_size", "internet", "garage", "elevator", "air_conditioning", "pool", "dishwasher", "fireplace", "balcony", "built_in", "lot_width", "lot_depth", "stories", "room_count", "parking_spaces", "property_video", "property_virtual_tour", "property_agent", "property_gallery", "property_floor_plans", "property_calc", "property_featured", "spese_condominiali", "classe_energetica", "stato_immobile", "mq_sotto", "piano", "codice");
 //print_r($ARR1);die();

 $ARR2 = array_fill(0, 44, '');

 $ARR_lang = array('it', 'en', 'de');
 
 $ARR_locality = array("Bardolino", "Garda", "Costermano sul Garda" );

 $PIANI_IT = array('Piano terra', 'Primo piano', 'Secondo piano', 'Terzo piano', 'Quarto piano', 'Quinto piano');
 $PIANI_EN = array('Ground Floor', 'First Floor', 'Second Floor', 'Third Floor', 'Fourth Floor', 'Fifth Floor');
 $PIANI_DE = array('Erdgeschoss', 'Erster Stock', 'Zweiter Stock', 'Dritter Stock', 'Vierter Stock', 'Fünfter Stock');



 /*$sql = 'INSERT INTO `85OCfh1_posts` (post_content, post_title, post_type) VALUES ("Prova", "TEST","property" )';die();
   print_r(dbDelta($sql));*/

 //GET ALL  
 $url = "http://partner.miogest.com/agenzie/gardahomeproject.xml";//"http://partner.miogest.com/agenzie/demo.xml";
 $xml = simplexml_load_file($url);

 $json = json_encode($xml);
 $array = json_decode($json,TRUE);
 //print_r(count($array['Annuncio']));

 //GET CATEGORY
 $url = "http://www.miogest.com/apps/revo.aspx?tipo=categorie";
 $xml1 = simplexml_load_file($url);

 $json1 = json_encode($xml1);
 $arrayCat = json_decode($json1,TRUE);

 //GET STATO IMM
 $url = "http://www.miogest.com/apps/revo.aspx?tipo=schede";
 $xml2 = simplexml_load_file($url);

 $json2 = json_encode($xml2);
 $arrayStato = json_decode($json2,TRUE);

 $statoAbit;
 $statoAbitEN;
 $statoAbitDE;
 //print_r($arrayStato['scheda']);
 for($o=0; $o<count($arrayStato['scheda']); $o++){
   if($arrayStato['scheda'][$o]['id']==57){
     $statoAbit = $arrayStato['scheda'][$o]['valori']['valore'];
     $statoAbitEN = $arrayStato['scheda'][$o]['valori_en']['valore'];
     $statoAbitDE = $arrayStato['scheda'][$o]['valori_de']['valore'];

   }


 }

 //DELETE PREV

 $result = $wpdb->get_results ( "
   SELECT * 
   FROM 85OCfh1_gestionale
 " );


 foreach ( $result as $s )
 {	
   $wpdb->delete( '85OCfh1_posts', array( 'ID' => $s->id ) );
   $wpdb->delete( '85OCfh1_icl_translations', array( 'element_id' => $s->id ) );
   $wpdb->delete( '85OCfh1_term_relationships', array( 'object_id' => $s->id ) );
   $wpdb->delete( '85OCfh1_postmeta', array( 'post_id' => $s->id ) );
   $wpdb->delete( '85OCfh1_gestionale', array( 'id' => $s->id ) );
 }

 //INSERT ALL

 for($i=0; $i<count($array['Annuncio']); $i++){

   $img_str = "";

   if (array_key_exists('Foto', $array['Annuncio'][$i])) {

   //UPLOAD IMAGE

	   if(is_array($array['Annuncio'][$i]['Foto'])) {

		 for($y=0; $y<count($array['Annuncio'][$i]['Foto']); $y++){

		 $image_url = explode("/", $array['Annuncio'][$i]['Foto'][$y]);

		 if($y == 0)
		   $img_str .= $image_url[4];
		 else
		   $img_str = $img_str . "," . $image_url[4] ;

		 }


	   } else {


		 $image_url = $array['Annuncio'][0]['Foto'][$y];

		 $img_str .= $image_url;

	   } 

   } 



   //Create post of property in italian
   $wpdb->insert( 
     '85OCfh1_posts', array( 
       'post_content'     => (!is_array($array['Annuncio'][$i]['Descrizione']) ? $array['Annuncio'][$i]['Descrizione'] : ''),
       'post_title'    => (!is_array($array['Annuncio'][$i]['Titolo']) ? $array['Annuncio'][$i]['Titolo'] : $i . '_IT' ),
       'post_name' => str_replace(' ', '_', strtolower((!is_array($array['Annuncio'][$i]['Titolo']) ? $array['Annuncio'][$i]['Titolo'] : $i . '_IT'))),
       'post_type' => "property",
       'post_date'      => $now,
       'post_date_gmt'      => $now,
       'post_modified'      => $now,
       'post_modified_gmt'      => $now,
	   'comment_status' => "closed",
       'post_status' => "publish",
       'ping_status' => "closed"
     )

   );

   $record_id = $wpdb->insert_id;

   //$wpdb->update('85OCfh1_posts', array('guid'=>$base_url . $record_id), array('id'=>$record_id));

   //Create post of property in EN
   $wpdb->insert( 
     '85OCfh1_posts', 
     array( 
       'post_content'     => (!is_array($array['Annuncio'][$i]['Descrizione_En']) ? $array['Annuncio'][$i]['Descrizione_En'] : ''),
       'post_title'    => (!is_array($array['Annuncio'][$i]['Titolo_En']) ? $array['Annuncio'][$i]['Titolo_En'] : $array['Annuncio'][$i]['Titolo'] . '_EN'),
       'post_type' => "property",
       'post_name' => str_replace(' ', '_', strtolower((!is_array($array['Annuncio'][$i]['Titolo_En']) ? $array['Annuncio'][$i]['Titolo_En'] : $i . '_EN'))),
       'post_date'      => $now,
       'post_date_gmt'      => $now,
       'post_modified'      => $now,
       'post_modified_gmt'      => $now,
		 'comment_status' => "closed",
       'post_status' => "publish",
       'guid' => $base_url,
       'ping_status' => "closed"
     )
   );

   $record_id_en = $wpdb->insert_id;

   $wpdb->update('85OCfh1_posts', array('guid'=>$base_url . $record_id_en), array('id'=>$record_id_en));

   //Create post of property in DE
   $wpdb->insert( 
     '85OCfh1_posts', 
     array( 
       'post_content'     => (!is_array($array['Annuncio'][$i]['Descrizione_De']) ? $array['Annuncio'][$i]['Descrizione_De'] : ''),
       'post_title'    => (!is_array($array['Annuncio'][$i]['Titolo_De']) ? $array['Annuncio'][$i]['Titolo_De'] : $array['Annuncio'][$i]['Titolo'] . '_DE'),
       'post_type' => "property",
       'post_name' => str_replace(' ', '_', strtolower((!is_array($array['Annuncio'][$i]['Titolo_De']) ? $array['Annuncio'][$i]['Titolo_De'] : $i . '_DE'))),
       'post_date'      => $now,
       'post_date_gmt'      => $now,
       'post_modified'      => $now,
       'post_modified_gmt'      => $now,
		 'comment_status' => "closed",
       'post_status' => "publish",
       'guid' => $base_url,
       'ping_status' => "closed"
     )
   );

   $record_id_de = $wpdb->insert_id;

   $wpdb->update('85OCfh1_posts', array('guid'=>$base_url . $record_id_de), array('id'=>$record_id_de));


   //insert in gestionale table IT
   $wpdb->insert( 
     '85OCfh1_gestionale', 
     array( 
       'id'    => $record_id,
       'type' => "1",
     )
   );

   $wpdb->insert( 
     '85OCfh1_gestionale', 
     array( 
       'id'    => $record_id_en,
       'type' => "1",
     )
   );

   $wpdb->insert( 
     '85OCfh1_gestionale', 
     array( 
       'id'    => $record_id_de,
       'type' => "1",
     )
   );

   //echo "Post ID -> IT " . $record_id . " | EN " . $record_id_en . " | DE " . $record_id_de;

   $maxtrid = 1 + $wpdb->get_var( "SELECT MAX(trid) FROM 85OCfh1_icl_translations" );
   //Connect translations IT

   $wpdb->insert( 
     '85OCfh1_icl_translations', 
     array( 
       'element_type' => "post_property",
       'element_id'      => $record_id,
       'trid'      => $maxtrid,
       'language_code'      => 'it',
       'source_language_code'      => 'it'
     )
   );

   $record_id_trad_it = $wpdb->insert_id;

   //Connect translations EN

   $wpdb->insert( 
     '85OCfh1_icl_translations', 
     array( 
       'element_type' => "post_property",
       'element_id'      => $record_id_en,
       'trid'      => $maxtrid,
       'language_code'      => 'en',
       'source_language_code'      => 'it'
     )
   );

   $record_id_trad_en = $wpdb->insert_id;

   //Connect translations DE

   $wpdb->insert( 
     '85OCfh1_icl_translations', 
     array( 
       'element_type' => "post_property",
       'element_id'      => $record_id_de,
       'trid'      => $maxtrid,
       'language_code'      => 'de',
       'source_language_code'      => 'it'
     )
   );

   $record_id_trad_de = $wpdb->insert_id;



   //RELATIONSHIP Details about the post (publish, post category, ..)

   //ARRAYS FOR category
   $arr_cat_miogest = array(17,18,25,26,28,119,50,30,32,87,44,46,91,127,117,48,84,34,105,123,125,83,95,33,93,97,40,41,42,85,99,36,82,81,86,1);


   

   for($s=0; $s<count($ARR_lang); $s++){
     if($s==0)
     	$r=$record_id;
     else if($s==1)
     	$r=$record_id_en;
     else if($s==2)
     	$r=$record_id_de;


     if (array_key_exists('Categoria', $array['Annuncio'][$i])) {
       if(is_array($array['Annuncio'][$i]['Categoria'])) {
         for($y=0; $y<count($array['Annuncio'][$i]['Categoria']); $y++){
           $key = 21 + intval(array_search( $array['Annuncio'][$i]['Categoria'][$y], $arr_cat_miogest) );
           $wpdb->insert( 
             '85OCfh1_term_relationships', 
             array( 	
               'object_id' => $r, 
               'term_taxonomy_id' => $key, 
               'term_order' =>	0
             )
           );
			 echo "<br>" . $array['Annuncio'][$i]['Codice'] . " -> " . $array['Annuncio'][$i]['Categoria'][$y] .  " | " . $key . " | " . array_search( $array['Annuncio'][$i]['Categoria'][$y], $arr_cat_miogest );

         }
       } else {
         $key = 21 + intval(array_search( $array['Annuncio'][$i]['Categoria'], $arr_cat_miogest) );
         $wpdb->insert( 
           '85OCfh1_term_relationships', 
           array( 	
             'object_id' => $r, 
             'term_taxonomy_id' => $key, 
             'term_order' =>	0
           )
         );
		   echo "<br>" . $array['Annuncio'][$i]['Codice'] . " -> " . $array['Annuncio'][$i]['Categoria'] .  " | " . $key . " | " . array_search( $array['Annuncio'][$i]['Categoria'], $arr_cat_miogest );
       }
     }

     $wpdb->insert( 
       '85OCfh1_term_relationships', 
       array( 	
         'object_id' => $r, 
         'term_taxonomy_id' => 11, 
         'term_order' =>	0
       )
     );
   }

   for($s=0; $s<count($ARR_lang); $s++){
    if($s==0)
      $r=$record_id;
    else if($s==1)
      $r=$record_id_en;
    else if($s==2)
      $r=$record_id_de;

     //POSTMETA Price and other details about property
     $ARR2[8] = str_replace(' ', '', strtolower($array['Annuncio'][$i]['Comune']));
     $ARR2[35] = $img_str;
     if(!is_array($array['Annuncio'][$i]['Prezzo']))
       $ARR2[11] = $array['Annuncio'][$i]['Prezzo'];
     if(!is_array($array['Annuncio'][$i]['Anno']))
       $ARR2[26] = $array['Annuncio'][$i]['Anno'];
     /*if(!is_array($array['Annuncio'][$i]['PostiAuto']))
       $ARR2[31] = $array['Annuncio'][$i]['PostiAuto'];*/
     if(!is_array($array['Annuncio'][$i]['Classe']))
       $ARR2[40] = $array['Annuncio'][$i]['Classe'];

     $stringStat="";
     if(!is_array($array['Annuncio'][$i]['Scheda_StatoImmobile'])){

       if($s!=0){

         for($t=0; $t<count($statoAbit); $t++){

           if($statoAbit[$t]==$array['Annuncio'][$i]['Scheda_StatoImmobile']){
             if($s==1)
               $stringStat = $statoAbitEN[$t];
             else
               $stringStat = $statoAbitDE[$t];

             //echo '<br> Stato ab: ' . $stringStat . '  ' . $array['Annuncio'][$i]['Scheda_StatoImmobile']. '<br>';
             //print_r($arrayStato['scheda'][$o]['valori'][$t]);
           }
         }
         $ARR2[41] = $stringStat;
       } else {
         $ARR2[41] = $array['Annuncio'][$i]['Scheda_StatoImmobile'];
       }
     }

     /*if(!is_array($array['Annuncio'][$i]['Piano']))
       $ARR2[43] = $array['Annuncio'][$i]['Piano'];*/
     if(!is_array($array['Annuncio'][$i]['Piano'])){
       $stringPiano="";
       $piano = intval($array['Annuncio'][$i]['Piano']);
       if($s==0)
         $stringPiano=$PIANI_IT[$piano];
       else if($s==1)
         $stringPiano=$PIANI_EN[$piano];
       else if($s==2)
         $stringPiano=$PIANI_DE[$piano];
       $ARR2[43] = $stringPiano;
       //print_r($stringPiano);
       //echo "<br>Piano " . $stringPiano . " | " . $piano . " | " . $s . "<br>";
       //print_r($PIANO_IT);

     } else {
       $ARR2[43] = intval($array['Annuncio'][$i]['Piano']);
     }

     if(!is_array($array['Annuncio'][$i]['Codice']))
       $ARR2[44] = $array['Annuncio'][$i]['Codice'];
     if(!is_array($array['Annuncio'][$i]['Mq'])){
       $ARR2[17] = $array['Annuncio'][$i]['Mq'];
       $ARR2[42] = $array['Annuncio'][$i]['Mq'];
     }

     //AGENT
     $ARR2[34] = '290';
     //FEATURED
     if($i<4)
       $ARR2[38] = '1';


     /*
     $stringTip="";
     if(!is_array($array['Annuncio'][$i]['Categoria'])){		
       for($y=0; $y<count($arrayCat['cat']); $y++){
         if( $arrayCat['cat'][$y]['id'] == $array['Annuncio'][$i]['Categoria'] ){
           if($s==0)
             $stringTip=$arrayCat['cat'][$i]['nome'];
           else if($s==1)
             $stringTip=$arrayCat['cat'][$i]['nome_en'];
           else if($s==2)
             $stringTip=$arrayCat['cat'][$i]['nome_de'];
         }
       }	
     } else {
       echo "<br>Conteggio: " . count($array['Annuncio'][$i]['Categoria']) . "<br>";
       for($u=0; $u<count($array['Annuncio'][$i]['Categoria']); $u++){
         print_r( $array['Annuncio'][$i]['Categoria'][$u] ); echo " ";
         for($y=0; $y<count($arrayCat['cat']); $y++){
           if( $arrayCat['cat'][$y]['id'] == $array['Annuncio'][$i]['Categoria'][$u] ){
             if($u==0){
               if($s==0)
                 $stringTip=$arrayCat['cat'][$y]['nome'];
               else if($s==1)
                 $stringTip=$arrayCat['cat'][$y]['nome_en'];
               else if($s==2)
                 $stringTip=$arrayCat['cat'][$y]['nome_de'];
             } else {
               if($s==0)
                 $stringTip=$stringTip . " | " . $arrayCat['cat'][$y]['nome'];
               else if($s==1)
                 $stringTip=$stringTip . " | " . $arrayCat['cat'][$y]['nome_en'];
               else if($s==2)
                 $stringTip=$stringTip . " | " . $arrayCat['cat'][$y]['nome_de'];
             }
           }
         }
       }
     }
     //echo "Tipo: " . $stringTip . "<br>";
     $ARR2[42] = $stringTip;*/



     for($x=0; $x<count($ARR2); $x++){

       if($x ==35)
         print_r($ARR2[$x]);

       $wpdb->insert( 
         '85OCfh1_postmeta', 
         array( 		
           'post_id' => $r, 
           'meta_key' => $ARR1[$x], 
           'meta_value' => $ARR2[$x]
         )
       );
     }
     }



   /*

   85OCfh1_posts

     (285, 1, '2021-04-21 17:03:00', '2021-04-21 15:03:00', 'Prova', 'Test', '', 'publish', 'open', 'closed', '', 'test', '', '', '2021-04-21 17:03:09', '2021-04-21 15:03:09', '', 0, 'https://gardahomeproject.it/prova/?post_type=property&#038;p=285', 0, 'property', '', 0); */
   echo "<br>__________________________<br>";
 }
 
}



/* property NOT NECESSARY


//Populate the translation_status table EN

$wpdb->insert( 
 '85OCfh1_icl_translation_status', 
 array( 
   'translation_id'    => $record_id_trad_en,
   'status'     => 9,
   'translator_id'    => 0,
   'needs_update' => 0,
   'batch_id'      => 0,
   'links_fixed'      => 0,
   'tp_revision'      => 1,
   'timestamp'      => $now
 )
);

//Populate the translation_status table DE

$wpdb->insert( 
 '85OCfh1_icl_translation_status', 
 array( 
   'translation_id'    => $record_id_trad_de,
   'status'     => 9,
   'translator_id'    => 0,
   'needs_update' => 0,
   'batch_id'      => 0,
   'links_fixed'      => 0,
   'tp_revision'      => 1,
   'timestamp'      => $now
 )
);

*/





?>