<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - Knockout Zone</title>
    <link rel="stylesheet" href="css/events.css">
</head>

<body>
    <div>
        <header>
            <nav>
                <a href="index.html" class="logo-container">
                    <img class="logo-container" src="../resources/images/logolight.png" alt="Knockout Zone Logo">
                </a>
                <ul class="nav-list">
                    <li><a href="vlogin.php">STORE</a></li>
                    <li><a href="vlogin.php">FORUM</a></li>
                    <li class="current">EVENTS</li>
                    <li><a href="vlogin.php">FIGHTERS</a></li>
                    <li><a href="vlogin.php">RANKING</a></li>
                </ul>
                <a href="profile.php" class="login-button">
                    <?php
                    if (isset($row['user']) && isset($row['path_pfp'])) {
                        echo '<img src="../resources/profiles/' . htmlspecialchars($row['path_pfp']) . '" alt="Profile Picture">';
                    } else {
                        echo '<img src="../resources/profiles/default-profile.png" alt="Default Profile Picture">';
                        }
                    ?>
                </a>
            </nav>
        </header>
        <img class="poster"
            src="../resources/images/events/muhammad-vs-della-maddalena-EVENT-ART.jpg"
            alt="Event Poster">
        <div class="title">UPCOMING EVENTS</div>
        <hr>
        <article>
            <section class="event-item">
                <img src="../resources/images/events/muhammad-della-event.png" alt="">
                <div class="event-info">
                    <h2>MUHAMMAD VS DELLA MADDALENA</h2>
                    <p>Sun, May 11 / 4:00 AM GMT+2 / Main Card</p>
                    <span>Bell Centre / Montreal QC, Canada</span>
                </div>
                <hr class="divider">
                <div class="event-button">
                    <a href="https://www.ticketmaster.com/discover/sports">BUY TICKETS</a>
                </div>
            </section>
            <section class="event-item">
                <img src="../resources/images/events/whittaker-deridder-event.png" alt="">
                <div class="event-info">
                    <h2>WHITTAKER VS DE RIDDER</h2>
                    <p>Sat, Jul 26 / 9:00 PM GMT+2 / Main Card</p>
                    <span>Ethiad Arena / Abu Dhabi, UAE</span>
                </div>
                <hr class="divider">
                <div class="event-button">
                    <a href="https://www.ticketmaster.com/discover/sports">BUY TICKETS</a>
                </div>
            </section>
            <section class="event-item">
                <img src="" alt="[PLACEHOLDER]">
                <div class="event-info">
                    <h2>[PLACEHOLDER]</h2>
                    <p>[PLACEHOLDER]</p>
                    <span>[PLACEHOLDER]</span>
                </div>
                <hr class="divider">
                <div class="event-button">
                    <a href="https://www.ticketmaster.com/discover/sports">BUY TICKETS</a>
                </div>
            </section>
            <section class="event-item">
                <img src="" alt="[PLACEHOLDER]">
                <div class="event-info">
                    <h2>[PLACEHOLDER]</h2>
                    <p>[PLACEHOLDER]</p>
                    <span>[PLACEHOLDER]</span>
                </div>
                <hr class="divider">
                <div class="event-button">
                    <a href="https://www.ticketmaster.com/discover/sports">BUY TICKETS</a>
                </div>
            </section>
        </article>
    </div>
</body>

</html>