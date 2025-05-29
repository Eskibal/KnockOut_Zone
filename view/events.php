<?php
session_start();

// Configuración de la base de datos
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'knockoutzone';

try {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }

    // Obtener eventos de la base de datos
    $events = [];
    $result = $conn->query("SELECT * FROM events ORDER BY event_date ASC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
    }
} catch (Exception $e) {
    $error_message = $e->getMessage();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Events - Knockout Zone</title>
    <link rel="stylesheet" href="css/events.css" />
    <link rel="icon" href="../resources/images/logolightbig.png" sizes="256x256" />
</head>

<body>
    <div>
        <header>
            <nav>
                <a href="home.html" class="logo-container">
                    <img class="logo-container" src="../resources/images/logolight.png" alt="Knockout Zone Logo" />
                </a>
                <ul class="nav-list">
                    <li><a href="store.html">STORE</a></li>
                    <li><a href="forum.html">FORUM</a></li>
                    <li class="current">EVENTS</li>
                    <li><a href="fighters.html">FIGHTERS</a></li>
                </ul>
                <a href="profile.php" class="login-button">
                    <img src="../resources/profiles/default-profile.png" alt="Default Profile Picture" />
                </a>
            </nav>
        </header>

        <div class="title">UPCOMING EVENTS</div>
        <hr class="d" />

        <article>
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                    <section class="event-item" data-event-datetime="<?= date('Y-m-d\TH:i', strtotime($event['event_date'])) ?>">
                        <?php if ($event['image_path']): ?>
                            <img src="../<?= htmlspecialchars($event['image_path']) ?>" alt="<?= htmlspecialchars($event['title']) ?>" />
                        <?php else: ?>
                            <img src="../resources/images/default-event.jpg" alt="Default Event Image" />
                        <?php endif; ?>
                        <div class="event-info">
                            <h2><?= htmlspecialchars($event['title']) ?></h2>
                            <p data-event-datetime="<?= date('Y-m-d\TH:i', strtotime($event['event_date'])) ?>">
                                <?= date('D, M j / g:i A T', strtotime($event['event_date'])) ?> / Main Card
                            </p>
                            <span><?= htmlspecialchars($event['location']) ?></span>
                            <p><?= htmlspecialchars($event['description']) ?></p>

                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['created_by']): ?>
                                <form action="../controller/delete_event.php" method="POST" style="margin-top: 1em;">
                                    <input type="hidden" name="event_id" value="<?= $event['id'] ?>" />
                                    <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar este evento?');">
                                        Eliminar evento
                                    </button>
                                </form>

                                <!-- Botón Editar agregado -->
                                <button class="edit-event-btn" 
                                        data-event-id="<?= $event['id'] ?>" 
                                        style="margin-top: 0.5em;">
                                    Editar evento
                                </button>
                            <?php endif; ?>
                        </div>
                        <hr class="divider" />
                        <div class="event-button">
                            <a href="https://www.ticketmaster.com/discover/sports">BUY TICKETS</a>
                        </div>
                    </section>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; margin: 2em;">No upcoming events found.</p>
            <?php endif; ?>
        </article>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div style="text-align: center; margin: 2em 0;">
                <button type="button" onclick="document.getElementById('create-event-form').style.display='block'">Create Event</button>
            </div>

            <div id="create-event-form" style="display:none; max-width:400px; margin:2em auto; padding:1em; border:1px solid #ccc; border-radius:8px; background:#fafafa;">
                <form action="../controller/create_event.php" method="POST" enctype="multipart/form-data">
                    <h3>Create New Event</h3>

                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div style="color: red; margin-bottom: 1em;">
                            <?= htmlspecialchars($_SESSION['error_message']) ?>
                            <?php unset($_SESSION['error_message']); ?>
                        </div>
                    <?php endif; ?>

                    <label for="event-title">Title:</label>
                    <input type="text" id="event-title" name="title" required style="width:100%;margin-bottom:1em;" />

                    <label for="event-date">Date & Time:</label>
                    <input type="datetime-local" id="event-date" name="datetime" required style="width:100%;margin-bottom:1em;" />

                    <label for="event-location">Location:</label>
                    <input type="text" id="event-location" name="location" required style="width:100%;margin-bottom:1em;" />

                    <label for="event-description">Description:</label>
                    <textarea id="event-description" name="description" rows="3" style="width:100%;margin-bottom:1em;"></textarea>

                    <label for="event-image">Event Image:</label>
                    <input type="file" id="event-image" name="event_image" accept="image/*" style="width:100%;margin-bottom:1em;" />

                    <button type="submit">Submit</button>
                    <button type="button" onclick="document.getElementById('create-event-form').style.display='none'">Cancel</button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Formulario oculto para editar evento -->
        <div id="edit-event-form" style="display:none; max-width:400px; margin:2em auto; padding:1em; border:1px solid #ccc; border-radius:8px; background:#fafafa;">
            <form action="../controller/update_events.php" method="POST" enctype="multipart/form-data">
                <h3>Edit Event</h3>

                <input type="hidden" id="edit-event-id" name="event_id" />

                <label for="edit-event-title">Title:</label>
                <input type="text" id="edit-event-title" name="title" required style="width:100%; margin-bottom:1em;" />

                <label for="edit-event-datetime">Date & Time:</label>
                <input type="datetime-local" id="edit-event-datetime" name="datetime" required style="width:100%; margin-bottom:1em;" />

                <label for="edit-event-location">Location:</label>
                <input type="text" id="edit-event-location" name="location" required style="width:100%; margin-bottom:1em;" />

                <label for="edit-event-description">Description:</label>
                <textarea id="edit-event-description" name="description" rows="3" style="width:100%; margin-bottom:1em;"></textarea>

                <label for="edit-event-image">Event Image:</label>
                <input type="file" id="edit-event-image" name="event_image" accept="image/*" style="width:100%; margin-bottom:1em;" />

                <button type="submit">Update</button>
                <button type="button" onclick="document.getElementById('edit-event-form').style.display='none'">Cancel</button>
            </form>
        </div>

        <footer>
            <div>
                <h3>KNOCKOUT ZONE</h3>
                <p><a href="aboutus.html">About us</a></p>
            </div>
            <div>
                <h3>SOCIAL MEDIA</h3>
                <p>Facebook</p>
                <p>Instagram</p>
                <p>X</p>
            </div>
            <div>
                <h3>HELP</h3>
                <p>Email</p>
            </div>
        </footer>
    </div>

    <script>
    document.querySelectorAll('.edit-event-btn').forEach(button => {
        button.addEventListener('click', () => {
            const eventId = button.getAttribute('data-event-id');
            
            // Buscar el contenedor del evento
            const eventSection = button.closest('.event-item');
            
            // Obtener datos visibles del evento
            const title = eventSection.querySelector('h2').textContent.trim();
            const datetime = eventSection.getAttribute('data-event-datetime');
            const location = eventSection.querySelector('span').textContent.trim();
            const description = eventSection.querySelectorAll('p')[1].textContent.trim();

            // Mostrar el formulario
            const form = document.getElementById('edit-event-form');
            form.style.display = 'block';

            // Setear valores en el formulario
            document.getElementById('edit-event-id').value = eventId;
            document.getElementById('edit-event-title').value = title;
            document.getElementById('edit-event-datetime').value = datetime;
            document.getElementById('edit-event-location').value = location;
            document.getElementById('edit-event-description').value = description;
        });
    });
    </script>
</body>
</html>
