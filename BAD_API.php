<?php
// BAD_API.php - Code volontairement mal structuré et non sécurisé

// Afficher les erreurs (en environnement de développement)
// Ne PAS activer en production !
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connexion directe à la base de données (mauvaise gestion des identifiants et absence de gestion des erreurs)
try {
    $db = new PDO('mysql:host=localhost;dbname=testdb', 'root', '');
} catch (PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}

// Récupérer la variable 'action' pour déterminer le comportement
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Exemple de routing basique non RESTful
if ($action == 'list_users') {
    // Pas de gestion des erreurs ni filtrage des entrées
    $result = $db->query("SELECT * FROM users");
    $users = $result->fetchAll(PDO::FETCH_ASSOC);
    
    // Pas de gestion des headers HTTP ni d'indication de succès ou d'erreur
    header('Content-Type: application/json');
    echo json_encode($users);

} elseif ($action == 'get_user') {
    // Récupération de l'ID directement depuis les paramètres GET sans validation
    $id = $_GET['id'];
    // Requête vulnérable à l'injection SQL (pas de préparation)
    $result = $db->query("SELECT * FROM users WHERE id = $id");
    $user = $result->fetch(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    if ($user) {
        echo json_encode($user);
    } else {
        // Retourne un message générique sans code d'erreur HTTP approprié
        echo json_encode(["error" => "User not found"]);
    }

} elseif ($action == 'create_user') {
    // Pas de différenciation entre GET et POST
    $name = $_POST['name'];
    $email = $_POST['email'];
    // Construction de la requête SQL sans échappement des données: injection SQL possible
    $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
    $result = $db->exec($sql);

    header('Content-Type: application/json');
    if ($result) {
        echo json_encode(["message" => "User created successfully"]);
    } else {
        echo json_encode(["error" => "Error creating user"]);
    }

} else {
    // Route par défaut peu explicite et sans gestion de méthodes HTTP
    header('Content-Type: application/json');
    echo json_encode(["error" => "Invalid action"]);
}
?>

/*

Analyse des Problèmes dans Ce Code

Architecture Monolithique :
Toute la logique se trouve dans un unique fichier,
sans séparation entre le traitement de la logique métier,
le routing et l'accès aux données.
Difficulté à évoluer et à tester les composants individuellement.

Sécurité :

Injection SQL :
Les paramètres utilisateurs (comme $_GET['id'], $_POST['name'], etc.) sont
insérés directement dans les requêtes SQL sans être échappés
ou utilisés dans des requêtes préparées.

Validation Inexistante :
Aucune vérification n’est réalisée sur les données entrantes.
Par exemple, la présence ou le format de l’email n’est pas contrôlé.

Gestion des Erreurs :
Les erreurs de requêtes SQL et autres dysfonctionnements ne sont pas gérés correctement,
rendant la détection et la correction des bugs plus difficiles.
Les réponses JSON ne sont pas accompagnées de codes d’état HTTP (comme 200, 400, 404, etc.)
pour informer clairement le client de l’état de la réponse.

Non Respect des Standards REST :
L’API ne distingue pas les méthodes HTTP (GET, POST, PUT, DELETE)
selon les opérations à réaliser. La route est déterminée
par un paramètre action plutôt que par des URLs claires et auto-descriptives.

Maintenance et Scalabilité :
L’absence de séparation logique et de modularité conduit à un code difficile à maintenir,
à lire et à étendre. Les retours d’erreurs trop génériques compliquent le diagnostic et
la correction des problèmes lorsque l’API est utilisée dans un environnement de production.


*/