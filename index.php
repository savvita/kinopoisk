<?php
require_once 'orm/UOW.php';
/* Create and Update Movie */
//    $res = null;
//    if(isset($_POST['submit']) ) {
//        $id = $_POST['id'] ?? 0;
//        $title = trim($_POST['title']);
//        $originalTitle = trim($_POST['originalTitle']);
//        $description = trim($_POST['description']);
//        $year = $_POST['year'];
//        $duration = $_POST['duration'];
//        $categoryId = $_POST['categoryId'];
//        $rate = $_POST['rate'];
//        $votes = $_POST['votes'];
//        $premium = $_POST['premium'];
////        $people = $_POST['staff_persons'];
////        $roles = $_POST['staff_roles'];
////        $staff = [];
////        for($i = 0; $i < count($people); $i++) {
////            $staff[] = new objects\Employee(0, new objects\Person($people[$i], ""), new \objects\Role($roles[$i], ""));
////        }
//        $staff_ids = $_POST['staff'];
//        print_r($_POST['staff']);
//        $staff = [];
//        foreach($staff_ids as $emp) {
//            if(empty($emp)){
//                continue;
//            }
//            $staff[] = new \objects\Employee(intval($emp), new \objects\Person(intval($emp), ""), new \objects\Role(1, ""));
//        }
//
//        $uow = new \orm\UOW(orm\DB::getInstance());
//        $movie = new objects\Movie($id, $title, $originalTitle, $description, $year, $duration, new objects\Category($categoryId, ""), $rate, $votes, $premium, [...$staff]);
//        echo '<pre>';
//        print_r($movie);
//        echo '</pre>';
//        $res = $uow->getMovies()->update($movie);
//
//    }
/* End Create */

/* Delete Movie */
    $res = null;
    if(isset($_POST['submit']) ) {
        $id = $_POST['id'] ?? 0;

        $uow = new \orm\UOW(orm\DB::getInstance());

        $res = $uow->getMovies()->delete($id);

    }
/* End Create */

$uow = new \orm\UOW(orm\DB::getInstance());
    $movies = $uow->getMovies()->select();
?>


<?php
//    require_once 'orm/UOW.php';
//
///* Create */
////    $res = null;
////    if(isset($_POST['value']) && !empty($_POST['value'])) {
////        $value = trim($_POST['value']);
////        if (strlen($value > 0) && strlen($value) < 50) {
////            $uow = new \orm\UOW(orm\DB::getInstance());
////            $res = $uow->getPeople()->create(new objects\Person(0, $value));
////            //$res = $uow->getRoles()->create(new objects\Role(0, $value));
////            //$res = $uow->getCategories()->create(new objects\Category(0, $value));
////        }
////    }
///* End Create */
//
///* Update */
////    $res = null;
////    if(isset($_POST['id']) && isset($_POST['value']) && !empty($_POST['value'])) {
////        $value = trim($_POST['value']);
////        if (strlen($value > 0) && strlen($value) < 50) {
////            $uow = new \orm\UOW(orm\DB::getInstance());
//////            $res = $uow->getCategories()->update(new objects\Category($_POST['id'], $value));
////            //$res = $uow->getRoles()->update(new objects\Role($_POST['id'], $value));
////            $res = $uow->getPeople()->update(new objects\Person($_POST['id'], $value));
////        }
////
////    }
//
///* End Update */
//
///* Delete */
//$res = null;
//if(isset($_POST['id'])) {
//
//    $uow = new \orm\UOW(orm\DB::getInstance());
//    $res = $uow->getPeople()->delete($_POST['id']);
//    //$res = $uow->getRoles()->delete($_POST['id']);
////    $res = $uow->getCategories()->delete($_POST['id']);
//
//}
///* End Delete */
//
//
//    $uow = new \orm\UOW(orm\DB::getInstance());
//    //$values = $uow->getCategories()->select();
//    //$values = $uow->getRoles()->select();
//    $values = $uow->getPeople()->select();
//?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<!--    <form action="index.php" method="POST">-->
<!--        <input type="text" name="id" />-->
<!--        <input type="text" name="value" />-->
<!--        <input type="submit" value="Delete" />-->
<!--    </form>-->
    <form action="index.php" method="POST">
        <input type="text" name="id" placeholder="id" />
        <input type="text" name="title" placeholder="title" />
        <input type="text" name="originalTitle" placeholder="originalTitle" />
        <input type="text" name="description" placeholder="description" />
        <input type="text" name="year" placeholder="year" />
        <input type="text" name="duration" placeholder="duration" />
        <input type="text" name="categoryId" placeholder="categoryId" />
        <input type="text" name="rate" placeholder="rate" />
        <input type="text" name="votes" placeholder="votes" />
        <input type="checkbox" name="premium" /> <label for="premium">Premium</label>
        <input type="text" name="staff_persons[]" placeholder="staff1_person" />
        <input type="text" name="staff_roles[]" placeholder="staff1_role" />
        <input type="text" name="staff_persons[]" placeholder="staff1_person" />
        <input type="text" name="staff_roles[]" placeholder="staff1_role" />
        <input type="text" name="staff[]" placeholder="staff_to_update" />
        <input type="text" name="staff[]" placeholder="staff_to_update" />
        <input type="text" name="staff[]" placeholder="staff_to_update" />
        <input type="text" name="staff[]" placeholder="staff_to_update" />

        <input type="submit" value="Update" name="submit" />
    </form>


    <?php if($res !== null) : ?>

    <p>Updated</p>
    <?php endif ?>
<!--    <table>-->
<!--        <thead>-->
<!--        <tr>-->
<!--            <th>Id</th>-->
<!--            <th>Value</th>-->
<!--        </tr>-->
<!--        </thead>-->
<!--        <tbody>-->
<!--            --><?php //foreach($values as $value) : ?>
<!--            <tr>-->
<!--                <td>--><?php //echo $value->getId(); ?><!--</td>-->
<!--                <td><?php ////echo $value->getValue(); ?></td>-->
<!--                <td>--><?php //echo $value->getName(); ?><!--</td>-->
<!--            </tr>-->
<!--            --><?php //endforeach ?>
<!--        </tbody>-->
<!--    </table>-->
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Original title</th>
            <th>Description</th>
            <th>Year</th>
            <th>Duration</th>
            <th>Category</th>
            <th>Rate</th>
            <th>Votes</th>
            <th>Premium</th>
            <th>Staff</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($movies as $movie) : ?>
            <tr>
                <td><?php echo $movie->getId() ?></td>
                <td><?php echo $movie->getTitle() ?></td>
                <td><?php echo $movie->getOriginalTitle() ?></td>
                <td><?php echo $movie->getDescription() ?></td>
                <td><?php echo $movie->getYear() ?></td>
                <td><?php echo $movie->getDuration() ?></td>
                <td><?php echo $movie->getCategory()->getValue() ?></td>
                <td><?php echo $movie->getRate() ?></td>
                <td><?php echo $movie->getVotes() ?></td>
                <td><?php echo $movie->getPremium() ?></td>
                <td><?php
                    $staff = $movie->getStaff();
                    $res = implode(', ', $staff);
                    echo $res;
                    ?>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>