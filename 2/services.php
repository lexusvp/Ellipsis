<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Quicksand:300,500" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <link href="../styles/main.css" rel="stylesheet">
        <link href="../styles/services.css" rel="stylesheet"> 
        <link href="../styles/second_main.css" rel="stylesheet"> 
        
        <script src="https://kit.fontawesome.com/8ce9f97409.js" crossorigin="anonymous"></script>
        
        <script type="text/javascript" src="../scripts/modules/controlerModule.js"></script>

        <script type="text/javascript" src="../scripts/modules/chatHandler.js" defer></script>
        <script type="text/javascript" src="../scripts/modules/formHandler.js" defer></script>
        <script type="text/javascript" src="../scripts/modules/searchHandler.js" defer></script>
        <script type="text/javascript" src="../scripts/modules/responsiveHandler.js" defer></script>

        <script type="text/javascript" src="../scripts/services.js" defer></script>
        <script type="text/javascript" src="../scripts/main.js" defer></script>
        <title>Services</title>
    </head>

    <body>
        <header>
            <img alt="header" src="../assets/images/header_img/services_head.png">
        </header>
        
        <section id="chat_container">
            <aside> <!-- ADMIN ONLY -->        
                <ul>
                    <li>
                        <img src="../assets/images/icons/chat_placeholder.png">
                    </li>  
                    <li>
                        <img src="../assets/images/icons/chat_placeholder.png">
                    </li>  
                    <li>
                        <img src="../assets/images/icons/chat_placeholder.png">
                    </li>  
                    <li>
                        <img src="../assets/images/icons/chat_placeholder.png">
                    </li>  
                    <li>
                        <img src="../assets/images/icons/chat_placeholder.png">
                    </li>  
                </ul>
                <button href="#"><i class="fa fa-bars"></i></button>
            </aside>
            <form name="chat">
                <header>
                    <img src="../assets/images/icons/chat_placeholder.png">
                    <div>
                        <h4> Mr. Dupont </h4>
                        <p> 14h25 </p>
                    </div>
                </header>
                <div id="messages_display"></div>
                <footer>
                    <input type="textarea" name="message" placeholder="Enter your message here !">
                </footer>
            </form>
        </section>

        <main>
            <nav>
                <div class="dropdown">
                    <button href="#" id="drop_button"><i class="fa fa-bars"></i></button>
                    <div class="dropdown_content">
                        <button class="tab_buttons"> Service 1 </button>
                        <button class="tab_buttons"> Service 2 </button>
                        <button class="tab_buttons"> Service 3 </button>
                        <button class="tab_buttons"> Service 4 </button>
                        <button class="tab_buttons"> Service 5 </button>
                    </div>
                </div>
                <input type="text" placeholder="Search.." name="search" autocomplete="off">
                <div class="autocomplete_box"></div>            
                <button type="submit"><i class="fa fa-search"></i></button>
            </nav>
            <section>
                <article class="activities">
                    <h2 class="content">Titre</h2>
                    <p class="content">London is the capital city of England.</p>
                    <img class="content" src="https://picsum.photos/700/400?random=1" alt="whatevr">
                </article>
                <article class="activities">
                    <h2 class="content">Titre 2 </h2>
                    <p class="content">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae ullam vel sunt, quod officia doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis numquam dolorem repudiandaeLorem ipsum, dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae ullam vel sunt, quod officia doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis numquam dolorem repudiandae.</p>
                    <img class="content" src="https://picsum.photos/700/400?random=2" alt="whatevr">
                </article>
                <article class="activities">
                    <h2 class="content">Titre 3 </h2>
                    <p class="content">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae ullam vel sunt, quod officia doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis numquam dolorem repudiandaeLorem ipsum, dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae ullam vel sunt, quod officia doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis numquam dolorem repudiandae.</p>
                    <img class="content" src="https://picsum.photos/700/400?random=3" alt="whatevr">
                </article>
                <article class="activities">
                    <h2 class="content">Titre 4 </h2>
                    <p class="content">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae ullam vel sunt, quod officia doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis numquam dolorem repudiandaeLorem ipsum, dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae ullam vel sunt, quod officia doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis numquam dolorem repudiandae.</p>
                    <img class="content" src="https://picsum.photos/700/400?random=4" alt="whatevr">
                </article>
                <article class="activities">
                    <h2 class="content">Titre 5 </h2>
                    <p class="content">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae ullam vel sunt, quod officia doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis numquam dolorem repudiandaeLorem ipsum, dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae ullam vel sunt, quod officia doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis numquam dolorem repudiandae.</p>
                    <img class="content" src="https://picsum.photos/700/400?random=5" alt="whatevr">
                </article>
            </section>
        </main>
        
        <nav id="main_menu">
            <ul>
                <li> 
                    <a href="../index.php">Acceuil</a>
                </li>                          
                <li> 
                    <a href="services.php">Services</a>
                </li>
                <li> 
                    <a href="account.php"> Account </a>
                </li>                        
                <li> 
                    <button id="chat_button"> Chat </button>
                </li> 
            </ul>         
        </nav>




    </body>
</html>