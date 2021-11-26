<?php
/**
 * @package WordPress
 * @subpackage Resideo
 */

if (!is_active_sidebar('pxp-first-footer-widget-area') && 
    !is_active_sidebar('pxp-second-footer-widget-area') && 
    !is_active_sidebar('pxp-third-footer-widget-area') && 
    !is_active_sidebar('pxp-fourth-footer-widget-area')) {
        return;
} ?>

<!-- selettore lingua widget newsletter 
<?php
if ( ICL_LANGUAGE_CODE == "it")  {
  echo "ciao";
} 
elseif ( ICL_LANGUAGE_CODE == "en")  {
  echo "hello";
} 
elseif ( ICL_LANGUAGE_CODE == "de")  {
  echo "mornin";
} ?>-->

<div class="row">
     <?php if (is_active_sidebar('pxp-fourth-footer-widget-area')) : ?>
	       <div class="container-fluid" style="padding:1rem!important;background-color:white;margin:0 auto;margin-bottom:80px;text-align:center">
			   <h3 class="myTitle2"><?php
if ( ICL_LANGUAGE_CODE == "it")  {
  echo "Iscriviti alla nostra Newsletter";
} 
elseif ( ICL_LANGUAGE_CODE == "en")  {
  echo "Subscribe to our Newsletter";
} 
elseif ( ICL_LANGUAGE_CODE == "de")  {
  echo "Registrieren Sie sich für unseren Newsletter";
} ?></h3>
			  <p style="text-align:center; font-size:1.2rem"><?php
if ( ICL_LANGUAGE_CODE == "it")  {
  echo "Iscriviti alla nostra newletter e riceverai una mail quando un immobile di tuo interesse verrà pubblicato.";
} 
elseif ( ICL_LANGUAGE_CODE == "en")  {
  echo "Subscribe to our newsletter and you will receive an email when a property of your interest is published.";
} 
elseif ( ICL_LANGUAGE_CODE == "de")  {
  echo "Melden Sie sich für unseren Newsletter an und Sie erhalten eine E-Mail, wenn eine Immobilie Ihres Interesses veröffentlicht wird.";
} ?></p>
			   
			   <!-- Button trigger modal -->
<?php
if ( ICL_LANGUAGE_CODE == "it")  { ?>
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#exampleModalCenter" >
  Iscriviti
</button>
	<?php }
elseif ( ICL_LANGUAGE_CODE == "en")  { ?>
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#exampleModalCenter" >
  Subscribe
</button>		
<?php	}
elseif ( ICL_LANGUAGE_CODE == "de")  { ?>
	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#exampleModalCenter" >
  Einschreiben
</button>
<?php	}  ?>
		
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php
if ( ICL_LANGUAGE_CODE == "it")  {
  echo "Iscriviti alla nostra Newsletter";
} 
elseif ( ICL_LANGUAGE_CODE == "en")  {
  echo "Subscribe to our Newsletter";
} 
elseif ( ICL_LANGUAGE_CODE == "de")  {
  echo "Registrieren Sie sich für unseren Newsletter";
} ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         
		  <div class="col-sm-12 col-lg-12">
                    <?php dynamic_sidebar('pxp-fourth-footer-widget-area'); ?>
                </div>    
      </div>
      
    </div>
  </div>
</div>
	</div>

              
            <?php endif; ?>

	
    <div class="col-sm-12 col-lg-12" style="margin-top:60px;">
        <div class="row">
			
			  <?php if (is_active_sidebar('pxp-first-footer-widget-area')) : ?>
        <div class="col-sm-12 col-lg-4">
            <?php dynamic_sidebar('pxp-first-footer-widget-area'); ?>
        </div>
    <?php endif; ?>
			
            <?php if (is_active_sidebar('pxp-second-footer-widget-area')) : ?>
                <div class="col-sm-12 col-md-4">
                    <?php dynamic_sidebar('pxp-second-footer-widget-area'); ?>
                </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('pxp-third-footer-widget-area')) : ?>
                <div class="col-sm-12 col-md-4">
                    <?php dynamic_sidebar('pxp-third-footer-widget-area'); ?>
                </div>
            <?php endif; ?>

          
        </div>
    </div>
</div>