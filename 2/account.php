<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Quicksand:300,500" rel="stylesheet">

        <link href="../styles/main.css" rel="stylesheet">
        <link href="../styles/account.css" rel="stylesheet">
        <link href="../styles/second_main.css" rel="stylesheet"> 

        <script src="../scripts/ext/node_modules/chart.js/dist/chart.js"></script>
        <script src="https://kit.fontawesome.com/8ce9f97409.js" crossorigin="anonymous"></script>

        <script type="text/javascript" src="../scripts/modules/controlerModule.js"></script>
        <script type="text/javascript" src="../scripts/modules/validationModule.js"></script>
        
        <script type="text/javascript" src="../scripts/modules/chatModule.js"></script>
        <script type="text/javascript" src="../scripts/modules/formModule.js"></script>
        <script type="text/javascript" src="../scripts/modules/displayModule.js"></script>

        <script type="text/javascript" src="../scripts/account.js" defer></script>
        <script type="text/javascript" src="../scripts/main.js" defer></script>    
        <title>My account</title>
    </head>

    <body>
        <?php session_start(); ?>
        <header>
            <img alt="header" src="../assets/images/header_img/account_head.png">
        </header>
        
        <section id="chat_container">
            <aside>     
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
            <form name = "chat">
                <header>
                    <img src="../assets/images/icons/chat_placeholder.png">
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
        
        <main>                
            <form action="update_account_form" name="update">
                <img alt="account" src="../assets/images/icons/account_icon.svg">
                
                <ul>
                    <li>Your actual pseudo is : <span id="user_pseudo"></span></li>
                </ul>
                <div>
                    <label for="pseudo"> New pseudo :</label>
                    <input type="text" name="pseudo" placeholder="Bob653">
                </div>
                <div>
                    <label for="password"> New password :</label>
                    <input type="password" name="password" placeholder="Z2Cn$%*e1256DF">    
                </div>
                <div>
                    <label for="email"> New email adress :</label>
                    <input type="text" name="email" placeholder="myemail@something.com">       
                </div>
                <div>
                    <label for="password"> Current password :</label>
                    <input type="password" name="current_password" placeholder="Z2Cn$%*e1256DF" required>    
                </div>
                <input type="submit" name="submit" class="buttons forms_buttons">
            </form>

            <header>
                <img alt="header" src="../assets/images/header_img/stats.png">
            </header>
            <section id="admin_section">
            </section>
        </main>

        <nav id="main_menu">
            <ul>
                <li> 
                    <a id="home_button" href="../index.php"> Home </a>
                </li>                          
                <li> 
                    <a id="services_button" href="services.php"> Services </a>
                </li>
                <li> 
                    <a id="account_button" href="account.php"> Account </a>
                </li>                    
                <li> 
                    <button id="chat_button"> Chat </button>
                </li> 
                <li>
                    <button id="logout_button"> Log Out </button>
                </li>    
            </ul>         
        </nav>



    </body>
</html>