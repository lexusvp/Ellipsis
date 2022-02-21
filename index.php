<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/logo/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500&family=Viga&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./styles/main.css">
    <link rel="stylesheet" href="./styles/home.css">
    <link rel="stylesheet" href="./styles/home_anim.css">
    <script src="./scripts/ext/node_modules/animejs/lib/anime.min.js"></script>
    
    <script type="text/javascript" src="./scripts/modules/displayModule.js"></script>
    <script type="text/javascript" src="./scripts/modules/controlerModule.js"></script>

    <script type="text/javascript" src="./scripts/modules/chatModule.js"></script>
    <script type="text/javascript" src="./scripts/modules/validationModule.js"></script>
    <script type="text/javascript" src="./scripts/modules/formModule.js"></script>

    <script type="text/javascript" src="./scripts/home.js" defer></script>
    <script type="text/javascript" src="./scripts/main.js" defer></script>

    <title>Home</title>
</head>

<body>
    <header>
        <nav id="main_menu" class="logged_specific">
            <ul>
                <li> 
                    <a id="home_button" href="index.php"> Home </a>
                </li>                          
                <li> 
                    <a id="services_button" href="2/services.php"> Services </a>
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
        <svg id="logo" width="100%" height="100%" viewBox="0 0 76 70">
            <path class="path" d="M22.779,1.948C29.252,-2.957 58.176,25.404 52.413,31.856C47.161,37.735 15.916,7.149 22.779,1.948Z" style="fill:none;stroke:rgb(63,63,63);stroke-width:2.76px;"/>
            <path class="path" d="M22.625,31.619C17.781,25.1 46.412,-3.556 52.809,2.268C58.639,7.574 27.761,38.531 22.625,31.619Z" style="fill:none;stroke:rgb(63,63,63);stroke-width:2.76px;"/>
            <path class="fadein" d="M21.253,40.032L54.153,40.032" style="fill:none;fill-rule:nonzero;stroke:rgb(63,63,63);stroke-width:1px;stroke-linejoin:miter;stroke-miterlimit:4;"/>
            <path class="fadein" d="M11.272,47.906L11.272,50.875L3.341,50.875L3.341,54.873L8.893,54.873L8.652,57.842L3.341,57.842L3.341,60.212C3.341,61.598 4.171,61.984 5.456,61.984L11.272,61.984L11.272,64.952L5.215,64.952C3.363,64.952 0.963,64.677 0.291,62.585C0.072,61.902 0,61.169 0,60.452L0,47.906L11.272,47.906Z" style="fill:rgb(63,63,63);"/>
            <path class="fadein" d="M17.305,64.952L14.18,64.976L14.18,46.949L17.305,46.949L17.305,64.952Z" style="fill:rgb(63,63,63);fill-opacity:0;fill-rule:nonzero;"/>
            <path class="fadein" d="M17.305,64.952L14.18,64.976L14.18,46.949L17.305,46.949L17.305,64.952Z" style="fill:rgb(63,63,63);"/>
            <path class="fadein" d="M23.674,64.952L20.549,64.976L20.549,46.949L23.674,46.949L23.674,64.952Z" style="fill:rgb(63,63,63);fill-opacity:0;fill-rule:nonzero;"/>
            <path class="fadein" d="M23.674,64.952L20.549,64.976L20.549,46.949L23.674,46.949L23.674,64.952Z" style="fill:rgb(63,63,63);"/>
            <path class="fadein" d="M28.625,46.063C29.378,46.063 29.866,46.179 30.091,46.41C30.315,46.641 30.427,47.128 30.427,47.87C30.427,48.613 30.311,49.099 30.079,49.331C29.846,49.562 29.358,49.678 28.613,49.678C27.868,49.678 27.379,49.558 27.146,49.319C26.914,49.079 26.798,48.593 26.798,47.858C26.798,47.124 26.914,46.641 27.146,46.41C27.379,46.179 27.872,46.063 28.625,46.063ZM30.163,64.952L27.038,64.952L27.038,51.785L30.163,51.785L30.163,64.952Z" style="fill:rgb(63,63,63);fill-opacity:0;fill-rule:nonzero;"/>
            <path class="fadein" d="M30.163,64.952L27.038,64.952L27.038,51.785L30.163,51.785L30.163,64.952ZM28.625,46.063C29.378,46.063 29.866,46.179 30.091,46.41C30.315,46.641 30.427,47.128 30.427,47.87C30.427,48.613 30.311,49.099 30.079,49.331C29.846,49.562 29.358,49.678 28.613,49.678C27.868,49.678 27.379,49.558 27.146,49.319C26.914,49.079 26.798,48.593 26.798,47.858C26.798,47.124 26.914,46.641 27.146,46.41C27.379,46.179 27.872,46.063 28.625,46.063Z" style="fill:rgb(63,63,63);"/>
            <path class="fadein" d="M44.607,57.746C44.607,61.305 43.686,63.58 41.843,64.569C41.09,64.968 40.169,65.168 39.079,65.168L36.772,63.684L36.772,69.022L33.648,69.022L33.648,51.378L39.8,51.378C41.659,51.378 42.925,51.9 43.598,52.946C44.271,53.991 44.607,55.591 44.607,57.746ZM41.483,58.225C41.483,55.528 40.618,54.179 38.887,54.179L36.772,54.179L36.772,60.523L38.887,61.888C39.816,61.888 40.481,61.597 40.882,61.014C41.283,60.432 41.483,59.502 41.483,58.225Z" style="fill:rgb(63,63,63);fill-opacity:0;fill-rule:nonzero;"/>
            <path class="fadein" d="M44.607,57.746C44.607,61.305 43.686,63.58 41.843,64.569C41.09,64.968 40.169,65.168 39.079,65.168L36.772,63.684L36.772,69.022L33.648,69.022L33.648,51.378L39.8,51.378C41.659,51.378 42.925,51.9 43.598,52.946C44.271,53.991 44.607,55.591 44.607,57.746ZM41.483,58.225C41.483,55.528 40.618,54.179 38.887,54.179L36.772,54.179L36.772,60.523L38.887,61.888C39.816,61.888 40.481,61.597 40.882,61.014C41.283,60.432 41.483,59.502 41.483,58.225Z" style="fill:rgb(63,63,63);"/>
            <path class="fadein" d="M56.528,61.17L56.528,61.529C56.432,62.726 55.923,63.628 55.002,64.234C54.081,64.841 52.931,65.144 51.553,65.144C49.518,65.144 48.092,64.777 47.275,64.043C46.522,63.372 46.145,62.383 46.145,61.074L46.145,60.787L48.981,60.787C48.981,61.521 49.174,62.024 49.558,62.295C49.943,62.566 50.608,62.702 51.553,62.702C52.835,62.702 53.476,62.239 53.476,61.313C53.476,60.547 53.251,60.037 52.803,59.781C52.595,59.653 52.33,59.558 52.01,59.494L49.582,59.087C47.467,58.752 46.41,57.435 46.41,55.137C46.41,53.86 46.878,52.866 47.816,52.156C48.753,51.446 49.943,51.09 51.385,51.09C54.669,51.09 56.312,52.503 56.312,55.328L56.312,55.639L53.596,55.639C53.564,54.889 53.364,54.378 52.995,54.107C52.627,53.836 52.11,53.7 51.445,53.7C50.78,53.7 50.279,53.832 49.943,54.095C49.606,54.358 49.438,54.65 49.438,54.969C49.438,55.879 49.807,56.397 50.544,56.525L53.452,57.052C55.503,57.435 56.528,58.808 56.528,61.17Z" style="fill:rgb(63,63,63);fill-opacity:0;fill-rule:nonzero;"/>
            <path class="fadein" d="M56.528,61.17L56.528,61.529C56.432,62.726 55.923,63.628 55.002,64.234C54.081,64.841 52.931,65.144 51.553,65.144C49.518,65.144 48.092,64.777 47.275,64.043C46.522,63.372 46.145,62.383 46.145,61.074L46.145,60.787L48.981,60.787C48.981,61.521 49.174,62.024 49.558,62.295C49.943,62.566 50.608,62.702 51.553,62.702C52.835,62.702 53.476,62.239 53.476,61.313C53.476,60.547 53.251,60.037 52.803,59.781C52.595,59.653 52.33,59.558 52.01,59.494L49.582,59.087C47.467,58.752 46.41,57.435 46.41,55.137C46.41,53.86 46.878,52.866 47.816,52.156C48.753,51.446 49.943,51.09 51.385,51.09C54.669,51.09 56.312,52.503 56.312,55.328L56.312,55.639L53.596,55.639C53.564,54.889 53.364,54.378 52.995,54.107C52.627,53.836 52.11,53.7 51.445,53.7C50.78,53.7 50.279,53.832 49.943,54.095C49.606,54.358 49.438,54.65 49.438,54.969C49.438,55.879 49.807,56.397 50.544,56.525L53.452,57.052C55.503,57.435 56.528,58.808 56.528,61.17Z" style="fill:rgb(63,63,63);"/>
            <path class="fadein" d="M60.734,46.063C61.487,46.063 61.976,46.179 62.2,46.41C62.424,46.641 62.537,47.128 62.537,47.87C62.537,48.613 62.42,49.099 62.188,49.331C61.956,49.562 61.467,49.678 60.722,49.678C59.977,49.678 59.488,49.558 59.256,49.319C59.024,49.079 58.908,48.593 58.908,47.858C58.908,47.124 59.024,46.641 59.256,46.41C59.488,46.179 59.981,46.063 60.734,46.063ZM62.272,64.952L59.148,64.952L59.148,51.785L62.272,51.785L62.272,64.952Z" style="fill:rgb(63,63,63);fill-opacity:0;fill-rule:nonzero;"/>
            <path class="fadein" d="M62.272,64.952L59.148,64.952L59.148,51.785L62.272,51.785L62.272,64.952ZM60.734,46.063C61.487,46.063 61.976,46.179 62.2,46.41C62.424,46.641 62.537,47.128 62.537,47.87C62.537,48.613 62.42,49.099 62.188,49.331C61.956,49.562 61.467,49.678 60.722,49.678C59.977,49.678 59.488,49.558 59.256,49.319C59.024,49.079 58.908,48.593 58.908,47.858C58.908,47.124 59.024,46.641 59.256,46.41C59.488,46.179 59.981,46.063 60.734,46.063Z" style="fill:rgb(63,63,63);"/>
            <path class="fadein" d="M75.179,61.17L75.179,61.529C75.082,62.726 74.574,63.628 73.652,64.234C72.731,64.841 71.581,65.144 70.204,65.144C68.169,65.144 66.743,64.777 65.925,64.043C65.172,63.372 64.796,62.383 64.796,61.074L64.796,60.787L67.632,60.787C67.632,61.521 67.824,62.024 68.209,62.295C68.593,62.566 69.258,62.702 70.204,62.702C71.485,62.702 72.126,62.239 72.126,61.313C72.126,60.547 71.902,60.037 71.453,59.781C71.245,59.653 70.981,59.558 70.66,59.494L68.233,59.087C66.118,58.752 65.06,57.435 65.06,55.137C65.06,53.86 65.529,52.866 66.466,52.156C67.404,51.446 68.593,51.09 70.035,51.09C73.32,51.09 74.962,52.503 74.962,55.328L74.962,55.639L72.246,55.639C72.214,54.889 72.014,54.378 71.646,54.107C71.277,53.836 70.76,53.7 70.095,53.7C69.43,53.7 68.93,53.832 68.593,54.095C68.257,54.358 68.089,54.65 68.089,54.969C68.089,55.879 68.457,56.397 69.194,56.525L72.102,57.052C74.153,57.435 75.179,58.808 75.179,61.17Z" style="fill:rgb(63,63,63);fill-opacity:0;fill-rule:nonzero;"/>
            <path class="fadein" d="M75.179,61.17L75.179,61.529C75.082,62.726 74.574,63.628 73.652,64.234C72.731,64.841 71.581,65.144 70.204,65.144C68.169,65.144 66.743,64.777 65.925,64.043C65.172,63.372 64.796,62.383 64.796,61.074L64.796,60.787L67.632,60.787C67.632,61.521 67.824,62.024 68.209,62.295C68.593,62.566 69.258,62.702 70.204,62.702C71.485,62.702 72.126,62.239 72.126,61.313C72.126,60.547 71.902,60.037 71.453,59.781C71.245,59.653 70.981,59.558 70.66,59.494L68.233,59.087C66.118,58.752 65.06,57.435 65.06,55.137C65.06,53.86 65.529,52.866 66.466,52.156C67.404,51.446 68.593,51.09 70.035,51.09C73.32,51.09 74.962,52.503 74.962,55.328L74.962,55.639L72.246,55.639C72.214,54.889 72.014,54.378 71.646,54.107C71.277,53.836 70.76,53.7 70.095,53.7C69.43,53.7 68.93,53.832 68.593,54.095C68.257,54.358 68.089,54.65 68.089,54.969C68.089,55.879 68.457,56.397 69.194,56.525L72.102,57.052C74.153,57.435 75.179,58.808 75.179,61.17Z" style="fill:rgb(63,63,63);"/>
        </svg>
        <img id="arrows" src="./assets/images/icons/down_arrows.svg" alt="arrows">
        <!-- <div id="anim_div">
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
        </div> -->
    </header>

    <main>
        <h2 class="subtitles" >Here's our services !</h2>
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
            <aside id="chat_tabs" class="admin_specific"></aside>
            <form name="chat">
                <header>
                    <img id="avatar" src="./assets/images/logo/round_white.png">
                    <div>
                        <span id="chat_name"></span>
                    </div>
                    <svg class="chat_icons admin_specific" id="chat_back" viewBox="0 0 512 512">
                        <path d="M384 320c-17.67 0-32 14.33-32 32v96H64V160h96c17.67 0 32-14.32 32-32s-14.33-32-32-32L64 96c-35.35 0-64 28.65-64 64V448c0 35.34 28.65 64 64 64h288c35.35 0 64-28.66 64-64v-96C416 334.3 401.7 320 384 320zM502.6 9.367C496.8 3.578 488.8 0 480 0h-160c-17.67 0-31.1 14.32-31.1 31.1c0 17.67 14.32 31.1 31.99 31.1h82.75L178.7 290.7c-12.5 12.5-12.5 32.76 0 45.26C191.2 348.5 211.5 348.5 224 336l224-226.8V192c0 17.67 14.33 31.1 31.1 31.1S512 209.7 512 192V31.1C512 23.16 508.4 15.16 502.6 9.367z"/>
                    </svg>
                </header>
                <div id="messages_display"></div>
                <footer>
                    <input type="textarea" name="message" placeholder="Enter your message here !">
                </footer>
            </form>
        </section>

        <section>
            <h2 class="subtitles" > Register now !</h2>
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

                        <button type="submit" value="" name="submit" class="buttons forms_buttons">
                            <img class="arrow_icon" src="./assets/images/icons/arrow_right.svg"></img>
                        </button>
                    </form>
                </div>
                <button class="modal_buttons buttons unlogged_specific" id="login_button"> Log in !</button>
                <div class="modal">
                    <form method="post" name="login">
                        <img src="./assets/images/icons/login_success.png" alt="">
                        <label for="email"> Enter your email :</label>
                        <input type="email" name="email" required>
                        <label for="password"> Enter your password :</label>
                        <input type="password" name="password" required>

                        <button type="submit" value="" name="submit" class="buttons forms_buttons">
                            <img class="arrow_icon" src="./assets/images/icons/arrow_right.svg"></img>
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>