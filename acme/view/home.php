<!DOCTYPE html>

 <html lang="en-us">
     <head>
         <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/head.php';?>
     </head>
     <body>
         <header class="topHeader">
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/header.php';?>
         </header>
         <nav>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/navigation.php';?>
         </nav>  
         <br>
         <main>
             <header>
                 <h1>Welcome to Acme!</h1>
                 <hr>
             </header>
             
             <div class="content-1">
                 <section class="coyote">
                         <ul class="overlay">
                            <li><h2>Acme Rocket</h2></li>
                            <li>Quick lighting fuse</li>
                            <li>NHTSA approved seat belts</li>
                            <li>Mobile launch stand included</li>
                            <li><a href="/acme/products/?action=item&item=1"><img id="actionbtn" alt="Add to cart button" src="/acme/images/site/iwantit.gif"></a></li>
                         </ul>
                 </section>
             </div>
             <div class="content-2">
                 <section>
                     <h2>Acme Rocket Reviews</h2>
                     <ul>
                        <li>"I don't know how I ever caught roadrunners before this." (4/5)</li>
                        <li>"That thing was fast!" (4/5)</li>
                        <li>"Talk about fast delivery." (5/5)</li>
                        <li>"I didn't even have to pull the meat apart." (4.5/5)</li>
                        <li>"I'm on my thirtieth one. I love these things!" (5/5)</li>
                     </ul>
                 </section>
                 <section class="recipeBox">
                     <h2>Featured Recipes</h2>
                     <div class="recipeContainer">
                         <div class="recipe">
                             <a href="" title="Link to pulled roadrunner bbq recipe">
                                 <img src="/acme/images/recipes/bbqsand.jpg" alt="Pulled Roadrunner BBQ" />
                                 <p>Pulled Roadrunner BBQ</p>
                             </a>
                         </div>
                         <div class="recipe">
                             <a href="" title="Link to roadrunner pot pie recipe">
                             <img src="/acme/images/recipes/potpie.jpg" alt="Roadrunner Pot Pie" />
                             <p>Roadrunner Pot Pie</p>
                             </a>
                         </div>
                         <div class="recipe">
                             <a href="" title="Link to roadrunner soup recipe">
                             <img src="/acme/images/recipes/soup.jpg" alt="Roadrunner Soup" />
                             <p>Roadrunner Soup</p>
                             </a>
                         </div>
                         <div class="recipe">
                             <a href="" title="link to roadrunner tacos recipe">
                             <img src="/acme/images/recipes/taco.jpg" alt="Roadrunner Tacos" />
                             <p>Roadrunner Tacos</p>
                             </a>
                         </div>
                     </div>
                 </section>
             </div>
             <hr>
         </main>
         <footer>
             <?php include $_SERVER['DOCUMENT_ROOT'].'/acme/common/footer.php';?>
         </footer>
     </body>
 </html>

