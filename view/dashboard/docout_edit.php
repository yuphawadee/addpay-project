<?php
// $uid = $_SESSION['id'];

if (isset($_GET['editdocout'])) {

    $id = $_GET['editdocout'];

    $sql = "SELECT * FROM docout WHERE docout_id ='$id'";
    $query = $conn->query($sql);
    $row = $query->fetch_assoc();
}

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'edit_docout') {

        $id = mysqli_real_escape_string($conn, trim($_POST['docout_id']));
        $no_check = mysqli_real_escape_string($conn, trim($_POST['no_check']));
        $input_no = mysqli_real_escape_string($conn, trim($_POST['input_no']));

        if ($input_no == $no_check) {

            edit_docout();
            exit;
        } else {

            $no_check_query = "SELECT * FROM docout WHERE docout_no = '$input_no'";
            $query = $conn->query($no_check_query);
            $check = $query->fetch_assoc();

            if ($check) {
                $_SESSION['error'] = "เลขที่นี้มีในระบบแล้ว!";
                header('Location: docout_edit.php?editdocout=' . $id);
                exit;
            } else {

                edit_docout();
                exit;
            }
        }
    }
}

function edit_docout()
{

    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");
    global $conn;

    $id = mysqli_real_escape_string($conn, trim($_POST['docout_id']));
    $input_no = mysqli_real_escape_string($conn, trim($_POST['input_no']));
    $input_date = mysqli_real_escape_string($conn, trim($_POST['input_date']));
    $input_title = mysqli_real_escape_string($conn, trim($_POST['input_title']));
    $input_to = mysqli_real_escape_string($conn, trim($_POST['input_to']));
    $input_send = mysqli_real_escape_string($conn, trim($_POST['input_send']));
    $input_content = mysqli_real_escape_string($conn, trim($_POST['input_content']));
    $input_name = mysqli_real_escape_string($conn, trim($_POST['input_name']));
    $input_position = mysqli_real_escape_string($conn, trim($_POST['input_position']));
    $uid = 1;

    $query = "UPDATE docout SET docout_no='$input_no', docout_date='$input_date', docout_title='$input_title', docout_to='$input_to',
        docout_send='$input_send', docout_details='$input_content', docout_signame='$input_name', docout_position='$input_position',
        docout_update='$date', docout_uid='$uid' WHERE docout_id ='$id'";

    if ($conn->query($query) === TRUE) {

        $_SESSION['success'] = "แก้ไขหนังสือออกสำเร็จ!";
        header("Location: docout_list.php");
        exit;
    } else {

        $_SESSION['error'] = "เกิดข้อผิดพลาด! กรุณาลองอีกครั้ง";
        header('Location: docout_edit.php?editdocout=' . $id);
        exit;
    }
}

?>

<style>
    .ck-editor__editable_inline {
        min-height: 250px;
    }
</style>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index">หน้าหลัก</a></li>
        <li class="breadcrumb-item"><a href="?page=doc">หนังสือ</a></li>
        <li class="breadcrumb-item"><a href="?page=doc_in">หนังสือออก</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขข้อมูลหนังสือออก</li>
    </ol>
</nav>
<hr>

<div class="container bg-secondary-addpay rounded-5">
    <div class="main-body p-md-5 text-white">
        <div id="docout_add" class="container p-3 p-md-5">

            <div class="p-4 p-md-5 bg-white rounded-5 shadow-lg">
                <div class="text-center text-md-start text-dark my-3">
                    <h3>แก้ไขข้อมูลหนังสือออก #</h3>
                </div>
                <form action="docout_add.php" method="post" name="docout_add" id="docout_add" class="p-md-5">
                    <div class="row align-items-center text-dark px-md-5 mb-3">
                        <div class="col-md-3">
                            <label for="input_no" class="col-form-label">เลขที่</label>
                        </div>
                        <div class="col-auto">
                            <input type="tetx" id="input_no" name="input_no" class="form-control " required>
                        </div>
                <div class=" px-md-5 py-md-4 justify-content-center">
                    <div class="p-2 py-md-4 px-md-5 border rounded-3">
                        <form action="docout_edit.php" method="post" name="docout_edit" id="docout_edit">
                            <div class=" row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="input_no" class="col-form-label">เลขที่</label>
                                </div>
                                <div class="col-auto">
                                    <input type="text" id="input_no" name="input_no" class="form-control " required
                                        value="<?= $row['docout_no'] ?>">
                                </div>
                            </div>
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="inputdate" class="col-form-label">วันที่ </label>
                                </div>
                                <div class="col-auto">
                                    <input type="date" id="input_date" name="input_date" class="form-control " required
                                        value="<?= $row['docout_date'] ?>">
                                </div>
                            </div>
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="input_title" class="col-form-label">ชื่อเรื่อง </label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="input_title" name="input_title" class="form-control "
                                        required value="<?= $row['docout_title'] ?>">
                                </div>
                            </div>
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3 ">
                                    <label for="input_to" class="col-form-label">เรียน (ถึงใคร) </label>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" id="input_to" name="input_to" class="form-control " required
                                        value="<?= $row['docout_to'] ?>">
                                </div>
                            </div>
                           

                            <div class="row g-3  mb-3 ">
                                <div class="col-md-3">
                                    <label for="input_send" class="col-form-label">สิ่งที่ส่งมาด้วย </label>
                                </div>
                                <div class="ck-send col-md-9 ">
                                    <textarea id="input_send" name="input_send" class="form-control" 
                                         placeholder="พิมพ์เนื้อหา..."><?= $row['docout_send'] ?></textarea>
                                </div>
                            </div>

                            <div class="row g-3  mb-3">
                                <div class="col-md-3">
                                    <label for="input_content" class="col-form-label">เนื้อหาข้อความ </label>
                                </div>
                                <div class="ck-details col-md-9">
                                    <textarea id="input_content" name="input_content" class="form-control" cols="40"
                                        rows="10" placeholder="พิมพ์เนื้อหา..."><?= $row['docout_details'] ?></textarea>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center mt-3">
                                <div class="col-md-3 ">
                                    <label for="input_name" class="col-form-label">ชื่อกำกับลายเซ็น</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="input_name" name="input_name" class="form-control " required
                                        value="<?= $row['docout_signame'] ?>">
                                </div>
                            </div>
                            <div class="row g-3 align-items-center mt-1 mb-3">
                                <div class="col-md-3 ">
                                    <label for="input_position" class="col-form-label">ตำแหน่งกำกับลายเซ็น</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="input_position" name="input_position" class="form-control "
                                        required value="<?= $row['docout_position'] ?>">
                                </div>
                            </div>
                            <div class="mx-auto d-flex justify-content-end">
                                <button type="reset"
                                    class=" btn btn-outline-danger btn btn-outline-success px-2 mt-2 rounded-3 fw-bold"><i
                                        class="fa-solid fa-eraser"></i> ล้างข้อมูล</button>
                                <button type="submit" name="action" value="edit_docout"
                                    class="ms-3  btn btn-outline-success px-2 mt-2 rounded-3  fw-bold">บันทึกการแก้ไข
                                    <i class="fa-solid fa-angles-right"></i></button>
                                <input type="hidden" name="no_check" id="no_check" value="<?= $row['docout_no'];?>" />
                                <input type="hidden" name="docout_id" id="docout_id" value="<?= $row['docout_id'];?>" />
                            </div>
                        </form>
                    </div>
                    <div class="row align-items-center text-dark px-md-5 mb-3">
                        <div class="col-md-3">
                            <label for="inputdate" class="col-form-label">วันที่ </label>
                        </div>
                        <div class="col-auto">
                            <input type="date" id="input_date" name="input_date" class="form-control " required>
                        </div>
                    </div>
                    <div class="row align-items-center text-dark px-md-5 mb-3">
                        <div class="col-md-3">
                            <label for="input_title" class="col-form-label">ชื่อเรื่อง </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="input_title" name="input_title" class="form-control " required>
                        </div>
                    </div>
                    <div class="row align-items-center text-dark px-md-5 mb-3">
                        <div class="col-md-3 ">
                            <label for="input_to" class="col-form-label">เรียน (ถึงใคร) </label>
                        </div>

                        <div class="col-md-6">
                            <input type="text" id="input_to" name="input_to" class="form-control " required>
                        </div>
                    </div>
                    <div class="row align-items-center text-dark px-md-5 mb-3">
                        <div class="col-md-3 ">
                            <label for="input_send" class="col-form-label">สิ่งที่ส่งมาด้วย </label>
                        </div>
                        <div class="col-md-6">
                            <textarea type="text" id="input_send" name="input_send" class="form-control " required rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row align-items-center text-dark px-md-5 mb-3">
                        <div class="col-md-3">
                            <label for="input_content" class="col-form-label">เนื้อหาข้อความ </label>
                        </div>
                        <div class=" col-md-9">
                            <textarea id="input_content" name="input_content" class="form-control" cols="40" rows="10" placeholder="พิมพ์เนื้อหา..."></textarea>
                        </div>
                    </div>
                    <div class="row align-items-center text-dark px-md-5 mb-3">
                        <div class="col-md-3 ">
                            <label for="input_name" class="col-form-label">ชื่อกำกับลายเซ็น</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="input_name" name="input_name" class="form-control " required>
                        </div>
                    </div>
                    <div class="row align-items-center text-dark px-md-5 mb-3">
                        <div class="col-md-3 ">
                            <label for="input_position" class="col-form-label">ตำแหน่งกำกับลายเซ็น</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="input_position" name="input_position" class="form-control " required>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn bg-secondary-addpay text-white me-3"><i class="fa-solid fa-arrow-rotate-left"></i> ล้างข้อมูล</button>
                                <button type="submit" class="btn btn-addpay text-white">บันทึก <i class="fa-solid fa-cloud-arrow-up"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $conn->close(); ?>