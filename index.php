<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,500" rel="stylesheet">
    
    <link rel="stylesheet" href="./styles/main.css">
    <link rel="stylesheet" href="./styles/home.css">
    <link rel="stylesheet" href="./styles/home_anim.css">
    
    <script src="https://kit.fontawesome.com/8ce9f97409.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./scripts/modules/controlerModule.js"></script>

    <script type="text/javascript" src="./scripts/modules/displayModule.js"></script>
    <script type="text/javascript" src="./scripts/modules/chatModule.js"></script>
    <script type="text/javascript" src="./scripts/modules/validationModule.js"></script>
    <script type="text/javascript" src="./scripts/modules/formModule.js"></script>

    <script type="text/javascript" src="./scripts/home.js" defer></script>
    <script type="text/javascript" src="./scripts/main.js" defer></script>
    <title>Home</title>
</head>
   
<body>
    <header>
        <nav id="main_menu">
            <ul>
                <li> 
                    <a id="home_button" href="index.php"> Home </a>
                </li>                          
                <li> 
                    <a id="services_button" href="2/services.php">Services</a>
                </li>
                <li> 
                    <a id="account_button" href="2/account.php"> Account </a>
                </li>                                       
                <li> 
                    <button id="chat_button"> Chat </button>
                </li> 
                <li>
                    <button id="logout_button"> Log Out </button>
                </li>

            </ul>         
        </nav>
        <img src="./assets/images/logo/full_black.png" alt="logo">
        <img src="./assets/images/icons/down_arrows.png" alt="logo" id="arrow">
        <div>                                        
            <div class='circle size_10'></div>
            <div class='circle size_9'></div>
            <div class='circle size_8'></div>
            <div class='circle size_7'></div>
            <div class='circle size_6'></div>
            <div class='circle size_5'></div>
            <div class='circle size_4'></div>
            <div class='circle size_3'></div>
            <div class='circle size_2'></div>
            <div class='circle size_1'></div>
        </div>
    </header>

    <main>
        <header>
            <img alt="welcome" src="./assets/images/header_img/main_head.png">
        </header>
        <section>
            <article>
                <img alt="stats" src="./assets/images/icons/statistics.svg">
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quo, aut cum. Reiciendis, pariatur ullam. Dicta magnam ab molestiae optio quo, eaque a, totam sapiente corporis atque aliquid voluptatum, fuga quia?Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio veniam illum aliquid perspiciatis fuga laborum temporibus fugiat laboriosam facere excepturi quaerat, ab optio maiores commodi recusandae assumenda ad?
                </p>
            </article>
            <article>
                <img alt="speed" src="./assets/images/icons/fast.svg">
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quo, aut cum. Reiciendis, pariatur ullam. Dicta magnam ab molestiae optio quo, eaque a, totam sapiente corporis atque aliquid voluptatum, fuga quia?Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio veniam illum aliquid perspiciatis fuga laborum temporibus fugiat laboriosam facere excepturi quaerat, ab optio maiores commodi recusandae assumenda ad?
                </p>
            </article>
            <article>
                <img alt="network" src="./assets/images/icons/network.svg">
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quo, aut cum. Reiciendis, pariatur ullam. Dicta magnam ab molestiae optio quo, eaque a, totam sapiente corporis atque aliquid voluptatum, fuga quia?Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio veniam illum aliquid perspiciatis fuga laborum temporibus fugiat laboriosam facere excepturi quaerat, ab optio maiores commodi recusandae assumenda ad?
                </p>
            </article>
        </section>

        <section id="chat_container">
            <aside>        
                <ul>
                    <li>
                        <img src="./assets/images/icons/chat_placeholder.png">
                    </li>  
                    <li>
                        <img src="./assets/images/icons/chat_placeholder.png">
                    </li>  
                    <li>
                        <img src="./assets/images/icons/chat_placeholder.png">
                    </li>  
                    <li>
                        <img src="./assets/images/icons/chat_placeholder.png">
                    </li>  
                    <li>
                        <img src="./assets/images/icons/chat_placeholder.png">
                    </li>  
                </ul>
                <button href="#"><i class="fa fa-bars"></i></button>
            </aside>
            <form name = "chat">
                <header>
                    <img src="./assets/images/icons/chat_placeholder.png">
                    <div>
                        <h4> ADMIN - Vazn </h4>
                    </div>
                </header>
                <div id = "messages_display"></div>
                <footer>
                    <input type="textarea" name="message" placeholder="Enter your message here !">
                </footer>
            </form>
        </section>

        <section>
            <header>
                <img alt="register" src="./assets/images/header_img/register.png">
            </header>
            <div>
                <img alt="account" src="./assets/images/icons/account_icon.svg">
                
                <button class="modal_buttons buttons" id="signup_button"> Sign up !</button>
                <div class="modal">
                    <form name="register">
                        <img src="./assets/images/icons/register_success.png" alt="">

                        <label for="pseudo"> Choose a pseudo :</label>
                        <input name="pseudo" type="text" required value="Azerty1">

                        <label for="password"> Choose a secure password :</label>
                        <input type="password" name="password" required value="Azerty11!">  

                        <span id="password_requirements"> 1 chiffre, 1 majuscule, 1 minuscule, 1 caractères spécial et 8 caractères minimum </span>  
                        <label for="email"> Enter your email adress :</label>
                        <input type="email" name="email" required value="cav@zap.com">       
                        
                        <button type="submit" value = "" name="submit"class="buttons forms_buttons"> 
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
                
                <button class="modal_buttons buttons" id="login_button"> Log in !</button>
                <div class="modal">
                    <form action="login_account_form" method="post" name="login">
                        <img src="./assets/images/icons/login_success.png" alt="">
                        <label for="email"> Enter your email :</label>
                        <input type="email" name="email" required>
                        <label for="password"> Enter your password :</label>
                        <input type="password" name="password" required>         
                        
                        <button type="submit" value = "" name="submit"class="buttons forms_buttons"> 
                            
                            <i class="fas fa-arrow-right"></i>
                        </button>                    
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>