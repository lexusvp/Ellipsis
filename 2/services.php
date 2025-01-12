<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500&family=Viga&display=swap"
      rel="stylesheet">
   <link rel="icon" href="../favicon.svg" type="image/svg+xml">

   <link href="../styles/main.css" rel="stylesheet">
   <link href="../styles/services.css" rel="stylesheet">
   <link href="../styles/second_main.css" rel="stylesheet">

   <script type="module" src="../scripts/services.js"></script>
   <title>Services</title>
</head>

<body>
   <h2 class="subtitles"> Services</h2>

   <section id="chat_container">
      <aside id="chat_tabs" class="admin_specific"></aside>
      <form name="chat">
         <header>
            <img id="avatar" src="../images/logo/round_white.png" />
            <div>
               <span id="chat_name"></span>
            </div>
            <svg class="chat_icons admin_specific" id="chat_back" viewBox="0 0 512 512">
               <path
                  d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z" />
            </svg>
         </header>
         <div id="messages_display"></div>
         <footer>
            <input type="textarea" name="message" placeholder="Enter your message here !"/>
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
         <input type="text" placeholder="Search.." name="search" autocomplete="off"/>
         <div class="autocomplete_box"></div>
         <button type="submit"><i class="fa fa-search"></i></button>
      </nav>
      <section>
         <article class="activities">
            <h2 class="content">Titre</h2>
            <p class="content">London is the capital city of England.</p>
            <img class="content" src="https://picsum.photos/700/400?random=1" alt="whatevr"/>
         </article>
         <article class="activities">
            <h2 class="content">Titre 2 </h2>
            <p class="content">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae
               ullam
               vel sunt, quod officia doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis
               numquam dolorem repudiandaeLorem ipsum,
               dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae ullam vel sunt, quod officia
               doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis numquam dolorem
               repudiandae.
            </p>
            <img class="content" src="https://picsum.photos/700/400?random=2" alt="whatevr"/>
         </article>
         <article class="activities">
            <h2 class="content">Titre 3 </h2>
            <p class="content">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae
               ullam
               vel sunt, quod officia doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis
               numquam dolorem repudiandaeLorem ipsum,
               dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae ullam vel sunt, quod officia
               doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis numquam dolorem
               repudiandae.
            </p>
            <img class="content" src="https://picsum.photos/700/400?random=3" alt="whatevr"/>
         </article>
         <article class="activities">
            <h2 class="content">Titre 4 </h2>
            <p class="content">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae
               ullam
               vel sunt, quod officia doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis
               numquam dolorem repudiandaeLorem ipsum,
               dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae ullam vel sunt, quod officia
               doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis numquam dolorem
               repudiandae.
            </p>
            <img class="content" src="https://picsum.photos/700/400?random=4" alt="whatevr"/>
         </article>
         <article class="activities">
            <h2 class="content">Titre 5 </h2>
            <p class="content">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae
               ullam
               vel sunt, quod officia doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis
               numquam dolorem repudiandaeLorem ipsum,
               dolor sit amet consectetur adipisicing elit. Est sequi incidunt molestiae ullam vel sunt, quod officia
               doloremque repellat, aliquam veniam obcaecati possimus hic adipisci nobis debitis numquam dolorem
               repudiandae.
            </p>
            <img class="content" src="https://picsum.photos/700/400?random=5" alt="whatevr"/>
         </article>
      </section>
   </main>

   <nav id="main_menu" class="logged_specific">
      <ul>
         <li>
            <a id="home_button" href="../index.php"> Home </a>
         </li>
         <li>
            <a id="services_button" href="./services.php"> Services </a>
         </li>
         <li>
            <a id="account_button" href="./account.php"> Account </a>
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