<?php
    preg_match("|/(.*)?/|i", $_SERVER['REQUEST_URI'], $matches);
    if(isset($matches[1]) && !empty($matches[1]))
    {
        $matches = explode("/",$matches[1]);
        header('Location: https://www.google.com/cse?q='.str_replace("-"," ",$matches[0]).'&cx=partner-pub-7383489556823532%3A3ullgkswitf&ie=UTF-8' );
    }
    
?>
<?php get_header(); ?>
<?php $options = get_option('inove_options'); ?>
<!-- heading START -->

<div id="heading"><h1>Stránka nenalezena !!</h1></div>
<!-- heading END-->
<!-- innerContent START-->
<div id="innerContent">
  <div id="notice">
    <h2>
      Vámi požadovaná stránka nebyla nalezna!
      <?php //_e('Welcome to 404 error page!', 'inove'); ?>
    </h2>

    <p>
      <?php //_e("Welcome to this customized error page. You've reached this page because you've clicked on a link that does not exist. This is probably our fault... but instead of showing you the basic '404 Error' page that is confusing and doesn't really explain anything, we've created this page to explain what went wrong.", 'inove'); ?>
      Na tuto stránku jste se zostali z toho důvodu, že jste klikli na odkaz, který vede na neexistující stánku.
      Pravděpodobně se jedná o naši chybu. V této chvíli můžete:
    </p>
    <ul>
        <li>Kliknout na tlačítko zpět svého prohlížeče</li>
        <li>Pokračovat výběrem jiného odkazu</li>
        <li>Využít vyhledávání</li>
        <li><a href="<?php bloginfo('url'); ?>">Přejít na úvodní stránku</a></li>
    </ul>
    <h3 style="margin-top: 20px;">
    Děkujeme
      <?php //_e("You can either (a) click on the 'back' button in your browser and try to navigate through our site in a different direction, or (b) click on the following link to go to homepage.", 'inove'); ?>
    </h3>
  </div>
</div>
<?php get_footer(); ?>
