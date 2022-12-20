<?php
session_start();
include('./includes/connect.php');

if (!isset($_SESSION['loggedin'])) {
    header("Location: home.php");
}

$userID = $_SESSION['userid'];

$accountInfo = pg_fetch_assoc(pg_query($dbConn, "SELECT * FROM public.users WHERE id = $userID"));


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyWiki | Accountdaten</title>
    <link rel="icon" type="image/x-icon" href="assets/brand/wikiLogo.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

    <?php include('./components/navbar.php'); ?>

    <br>

    <div class="container">

        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <img src="./assets/brand/wikiLogo.svg" class="rounded mx-auto d-block" height="100px"><br>
                    <h1 class="fw-light">Personal information</h1>
                    <p class="lead text-muted">Welcome to your account page on the myWiki! From here, you can
                        manage your personal information or view your contributions
                    </p>
                </div>
            </div>
        </section>

        <div class="row align-items-md-stretch">
            <div class="col-md-6">
                <div class="h-100 p-5 text-bg-dark rounded-3">
                    <h2>To sign out of your account, click the log out button in the menu.</h2>
                    <p></p>
                    <a href="logout.php"><button class="btn btn-outline-danger" type="button">Log out</button></a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="h-100 p-5 bg-light border rounded-3">
                    <h2>Information</h2>
                    <p>We are always working to keep the user interface as simple and understandable as possible.
                        However, questions still come up. You can find the most important answers listed in our <a
                            class="text-warning" style="text-decoration: none;" href="faq.php">FAQ.</a></p>
                </div>
            </div>
        </div>
        <br><br><br>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        What is my email?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Your email is <strong>
                            <?php echo $accountInfo['email'] ?>
                        </strong>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        What is my username?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Your username is <strong>
                            <?php echo $accountInfo['username'] ?>
                        </strong>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        I want to change my password!
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong><a class="text-warning" style="text-decoration: none;" href="">Reset
                                password</a></strong>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="jumbotron">
            <hr class="my-4">
            <p class="display-6">Here are all your contributions.</p>
            <hr class="my-4">
        </div><br>
        <div class="row">
            <?php while ($row = pg_fetch_assoc($results)) {

                $titel = $row['title'];
                $id = $row['id'];
                $cover = $row['cover'];
                $authorid = $row['author'];

                $getAuthor = pg_query($dbConn, "SELECT username FROM public.users WHERE id = '$authorid'");

                $cardAuthor = pg_fetch_assoc($getAuthor);

            ?>
            <div class="col-sm-6" style="width: 16rem;">
                <div class="card mb-4 text-black bg-light border border-dark">
                    <img src="./img/<?php echo $cover; ?>" class="card-img-top img-thumbnail"
                        style="height: 14rem; object-fit: cover;" alt="/img/<?php echo $cover; ?>">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $titel; ?>
                        </h5>
                        <p class="card-text">By:
                            <?php echo $cardAuthor['username']; ?>
                        </p>
                        <a href="post.php?id=<?php echo $id; ?>" class="btn btn-outline-dark">Read more</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php include('./components/footer.php'); ?>

        <div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
                integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
                integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk"
                crossorigin="anonymous"></script>
</body>

</html>