<?php
$action = $_REQUEST['action'];


if (!empty($action)) {
    require_once 'includes/Dog.php';
    $dog = new Dog();
}


if ($action == 'adddog' && !empty($_POST)) {
    $dogname = $_POST['dogname'];
    $type = $_POST['type'];
    $voice = $_POST['voice'];
    $canhunt = isset($_POST['canhunt']) ? 1 : 0;
    $dogId = $_POST['dogid'];

    $dogData = [
        'name' => $dogname,
        'type' => $type,
        'voice' => $voice,
        'can_hunt' => $canhunt,
    ];

    if ($dogId) {
        $dog->update($dogData, $dogId);
    } else {
        $dogId = $dog->add($dogData);
    }

    if (!empty($dogId)) {
        $dog = $dog->getRow('id', $dogId);
        echo json_encode($dog);
        exit();
    }
}


if ($action == "getdogs") {
    $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $limit = 4;
    $start = ($page - 1) * $limit;

    $dogs = $dog->getRows($start, $limit);
    if (!empty($dogs)) {
        $dogslist = $dogs;
    } else {
        $dogslist = [];
    }
    $total = $dog->getCount();
    $dogsArr = ['count' => $total, 'dogs' => $dogslist];
    echo json_encode($dogsArr);
    exit();
}


if ($action == "getdog") {
    $dogId = (!empty($_GET['id'])) ? $_GET['id'] : '';
    if (!empty($dogId)) {
        $dog = $dog->getRow('id', $dogId);
        echo json_encode($dog);
        exit();
    }
}


if ($action == "deletedog") {
    $dogId = (!empty($_GET['id'])) ? $_GET['id'] : '';
    if (!empty($dogId)) {
        $isDeleted = $dog->deleteRow($dogId);
        if ($isDeleted) {
            $message = ['deleted' => 1];
        } else {
            $message = ['deleted' => 0];
        }
        echo json_encode($message);
        exit();
    }
}


if ($action == 'search') {
    $queryString = (!empty($_GET['searchQuery'])) ? trim($_GET['searchQuery']) : '';
    $results = $dog->searchDog($queryString);
    echo json_encode($results);
    exit();
}
