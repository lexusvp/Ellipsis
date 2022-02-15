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
    <?php session_start(); ?>
    <header>
        <?php
            if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
                echo 
                '
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
                ';
            }
        ?>
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
            <?php
                if (isset($_SESSION["admin"])) {
                    if ($_SESSION["admin"] === true) {
                        echo 
                        '<aside id="chat_tabs">        

                        </aside>
                        ';
                    }
                }
            ?>     
            <form name = "chat">
                <header>
                    <img id="avatar" src="./assets/images/icons/chat_placeholder.png">
                    <div>
                        <span id="chat_header"></span>
                    </div>
                    <?php
                        if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
                            echo
                            '
                            <svg class="chat_icons" id="chat_back" viewBox="0 0 512 512">
                                <path d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                            </svg>
                            ';
                        }
                    ?>


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
                    <form method="post" name="register">
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
                
                <?php
                    if (empty($_SESSION["logged"])) {    
                        echo '<button class="modal_buttons buttons" id="login_button"> Log in !</button>'; 
                    }
                ?>
                <div class="modal">
                    <form method="post" name="login">
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