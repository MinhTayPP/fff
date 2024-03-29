<?php
require_once('./config/database.php');
spl_autoload_register(function ($className) {
    require_once('./models/' . $className . '.php');
});
session_start();
$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
$perpage = 5;
$product = new Product();

if(isset($_SESSION['search']))
{
    $findName = $_SESSION['search'];
    $totalProduct = $product->getTotalFindProducts($findName);
    $totalPage = ceil($totalProduct / $perpage);
    $productList = $product->getFindProducts($page, $perpage, $findName);
}

if (isset($_GET['search'])) {
    $findName = $_GET['search'];
    $_SESSION['search'] = $findName;
    $totalProduct = $product->getTotalFindProducts($findName);
    $totalPage = ceil($totalProduct / $perpage);
    $productList = $product->getFindProducts($page, $perpage, $findName);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Mobile Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./images/logo.png" type="image/icon type">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="css/uniform.css" />
    <link rel="stylesheet" href="css/select2.css" />
    <link rel="stylesheet" href="css/matrix-style.css" />
    <link rel="stylesheet" href="css/matrix-media.css" />
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <style type="text/css">
        ul.pagination {
            list-style: none;
            float: right;
        }

        ul.pagination li.active {
            font-weight: bold
        }

        ul.pagination li {
            display: flex;
            padding: 10px
        }
    </style>
</head>

<body>
    <!--Header-part-->
    <div id="header">
        <h1><a href="#"><img src="./images/logo.png" alt=""></a></h1>
    </div>
    <!--close-Header-part-->
    <!--top-Header-menu-->
    <div id="user-nav" class="navbar navbar-inverse">
        <ul class="nav">
            <li class="dropdown" id="profile-messages"><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i> <span class="text">Welcome Super Admin</span><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
                    <li class="divider"></li>
                    <li><a href="logout.html"><i class="icon-key"></i> Log
                            Out</a></li>
                </ul>
            </li>
            <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i>
                    <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> new message</a></li>
                    <li class="divider"></li>
                    <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> inbox</a></li>
                    <li class="divider"></li>
                    <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> outbox</a></li>
                    <li class="divider"></li>
                    <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> trash</a></li>
                </ul>
            </li>
            <li class=""><a title="" href="#"><i class="icon icon-cog"></i>
                    <span class="text">Settings</span></a></li>
            <li class=""><a title="" href="#"><i class="icon
                            icon-share-alt"></i> <span class="text">Logout</span></a>
            </li>
        </ul>
    </div>
    <!--start-top-serch-->
    <div id="search">
        <form action="result.php" method="get">
            <input type="text" name="search" placeholder="Search here..." />
            <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
        </form>
    </div>
    <!--close-top-serch-->
    <!--sidebar-menu-->
    <div id="sidebar"> <a href="#" class="visible-phone"><i class="icon
                    icon-th"></i>Tables</a>
        <ul>
            <li><a href="index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a>
            </li>
            <li> <a href="manufactures.php"><i class="icon icon-th-list"></i>
                    <span>Manufactures</span></a></li>
            <li> <a href="protypes.php"><i class="icon icon-th-list"></i>
                    <span>Product type</span></a></li>
            <li> <a href="users.php"><i class="icon icon-th-list"></i>
                    <span>Users</span></a></li>

        </ul>
    </div> <!-- BEGIN CONTENT -->
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom current"><i class="icon-home"></i> Home</a></div>
            <h6>Result: found <?php echo $totalProduct?> item(s) with keyword <?php echo $findName?></h6>
        </div>
        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><a href="form.html"> <i class="icon-plus"></i>
                                </a></span>
                            <h5>Products</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered
                                    table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Manufactures</th>
                                        <th>Product type</th>
                                        <th>Description</th>
                                        <th>Price (VND)</th>
                                        <th>Feature</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($productList as $item) :
                                    ?>
                                        <tr class="">
                                            <td width="250">
                                                <img src="./images/<?php echo $item['pro_image'] ?>" />
                                            </td>
                                            <td><?php echo $item['name'] ?></td>
                                            <td><?php echo $item['manu_name'] ?></td>
                                            <td><?php echo $item['type_name'] ?></td>
                                            <td><?php echo $item['description'] ?></td>
                                            <td><?php echo $item['price'] ?></td>
                                            <td><?php echo $item['feature'] ?></td>
                                            <td><?php echo $item['created_at'] ?></td>
                                            <td>
                                                <a href="#45" class="btn
                                                    btn-success btn-mini">Edit</a>
                                                <a href="#45" class="btn
                                                    btn-danger btn-mini">Delete</a>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach
                                    ?>
                                </tbody>
                            </table>
                            <?php if($totalPage > 1) {?>
                            <div class="row" style="margin-left: 18px;">
                                <ul class="pagination">
                                    <?php
                                    for ($i = 1; $i <= $totalPage; ++$i) :
                                        if ($page == $i) {
                                    ?>
                                            <li class="active"><a href="result.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                                        <?php
                                        } else {
                                        ?>
                                            <li><a href="result.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                                    <?php
                                        }
                                    endfor
                                    ?>
                                </ul>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    <div class="row-fluid">
        <div id="footer" class="span12"> 2017 &copy; TDC - Lập trình web 1</div>
    </div>
    <!--end-Footer-part-->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.ui.custom.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.uniform.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/matrix.js"></script>
    <script src="js/matrix.tables.js"></script>
</body>

</html>