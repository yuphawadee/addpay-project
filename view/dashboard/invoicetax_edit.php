<?php
if (isset($_GET['editinvtax'])) {

    $get_encode = $_GET['editinvtax'];
    $id = decode($get_encode, secret_key());

    $sql = "SELECT * FROM invoicetax WHERE invtax_id ='$id'";
    $query = $conn->query($sql);
    $row = $query->fetch_assoc();

    if (!$row) {
        $_SESSION['error'] = "ไม่พบหน้าดังกล่าว!";
        echo "<script> window.history.back()</script>";
        exit;
    }
}

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'edit_invoicetax') {

        $invtax_no_check = mysqli_real_escape_string($conn, trim($_POST['invtax_no_check']));
        $input_invtax_no = mysqli_real_escape_string($conn, trim($_POST['input_invtax_no']));

        if ($input_invtax_no == $invtax_no_check) {

            edit_invtax();
            exit;
        } else {

            $invtax_no_check = "SELECT * FROM invoicetax WHERE invtax_no =  '$input_invtax_no'";
            $query = $conn->query($invtax_no_check);
            $check = $query->fetch_assoc();

            if ($check) {
                $_SESSION['error'] = "เลขที่ใบแจ้งหนี้/ใบกำกับภาษีนี้มีในระบบแล้ว!";
                echo "<script> window.history.back()</script>";
                // header('Location: invoicetax_edit.php?editinvtax=' . $id);
                exit;
            } else {

                edit_invtax();
                exit;
            }
        }
    }
}

function edit_invtax()
{

    global $conn;
    date_default_timezone_set('Asia/Bangkok');
    $date = date("Y-m-d H:i:s");

    $id = mysqli_real_escape_string($conn, trim($_POST['invtax_id']));
    $invtax_date_create = mysqli_real_escape_string($conn, trim($_POST['invtax_date_create']));
    $input_invtax_no = mysqli_real_escape_string($conn, trim($_POST['input_invtax_no']));
    $input_invtax_date = mysqli_real_escape_string($conn, trim($_POST['input_invtax_date']));
    $input_invtax_name = mysqli_real_escape_string($conn, trim($_POST['input_invtax_name']));
    $input_invtax_address = mysqli_real_escape_string($conn, trim($_POST['input_invtax_address']));
    $input_invtax_cusid = mysqli_real_escape_string($conn, trim($_POST['input_invtax_cusid']));
    $input_invtax_sum = mysqli_real_escape_string($conn, trim($_POST['input_invtax_sum']));
    $input_invtax_vat = mysqli_real_escape_string($conn, trim($_POST['input_invtax_vat']));
    $input_invtax_total = mysqli_real_escape_string($conn, trim($_POST['input_invtax_total']));
    $uid = $_SESSION['id'];

    $query1 = "UPDATE invoicetax SET invtax_no='$input_invtax_no', invtax_date='$input_invtax_date',invtax_name='$input_invtax_name',
        invtax_address='$input_invtax_address', invtax_cusid='$input_invtax_cusid', invtax_sum='$input_invtax_sum',invtax_vat='$input_invtax_vat',
        invtax_total='$input_invtax_total',invtax_update='$date', invtax_uid='$uid' WHERE invtax_id='$id'";

    $query2 = "DELETE FROM invoicetax_details WHERE invtaxd_tid = '$id'";

    if ($conn->query($query1) === TRUE && $conn->query($query2) === TRUE) {

        for ($count = 0; $count < $_POST["total_item"]; $count++) {

            $item_name = mysqli_real_escape_string($conn, trim($_POST['item_name'][$count]));
            $item_amount = mysqli_real_escape_string($conn, trim($_POST['item_amount'][$count]));
            $item_price = mysqli_real_escape_string($conn, trim($_POST['item_price'][$count]));
            $total_price = mysqli_real_escape_string($conn, trim($_POST['total_price'][$count]));

            $query = "INSERT INTO invoicetax_details (invtaxd_tid, invtaxd_item, invtaxd_amount, invtaxd_price, invtaxd_result, invtaxd_create, invtaxd_update, invtaxd_uid)
                        VALUES ('$id', '$item_name', '$item_amount', '$item_price',  '$total_price','$invtax_date_create', '$date', '$uid')";
            $conn->query($query);
        }

        $_SESSION['success'] = "แก้ไขใบเสนอราคาสำเร็จ!";
        echo "<script> window.location.href='?page=invoicetax'</script>";
        exit;
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาด! กรุณาลองอีกครั้ง";
        echo "<script> window.history.back()</script>";
        exit;
    }
}

?>
<style>
    table {
        counter-reset: rowNumber;
    }

    table tr:not(:first-child) {
        counter-increment: rowNumber;
    }

    table tr td:first-child::before {
        content: counter(rowNumber);
        min-width: 1em;
        margin-right: 0.5em;
    }
</style>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index">หน้าหลัก</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="?page=invoicetax">ใบแจ้งหนี้/ใบกำกับภาษี</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขใบแจ้งหนี้/ใบกำกับภาษี</li>
    </ol>
</nav>
<hr>
<div class="container bg-secondary-addpay rounded-5">
    <div class="main-body py-md-5 px-md-1 text-white">
        <div id="papinvoicetaxtation" class="container p-3 p-md-5">
            <div class="p-4 p-md-5 bg-white rounded-5 shadow-lg">
                <div class="text-center text-md-start text-dark my-3">
                    <h3>แก้ไขข้อมูลใบแจ้งหนี้/ใบกำกับภาษี </h3>
                </div>
                <form method="post" id="invtax_form" action="?page=invoicetax_edit&editinvtax=<?php echo encode($row['invtax_id'], secret_key()); ?>" class="mt-md-5">
                    <div class="row align-items-center text-dark px-md-5 mb-3">
                        <div class="col-md-3 text-md-end">
                            <label for="input_invtax_no" class="col-form-label">เลขที่ No.</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" id="input_invtax_no" name="input_invtax_no" class="form-control " required value="<?= $row['invtax_no'] ?>">
                        </div>
                    </div>
                    <div class="row align-items-center text-dark px-md-5 mb-3">
                        <div class="col-md-3 text-md-end">
                            <label for="input_invtax_date" class="col-form-label">วันที่ date.</label>
                        </div>
                        <div class="col-auto">
                            <input type="date" id="input_invtax_date" name="input_invtax_date" class="form-control " required value="<?= $row['invtax_date'] ?>">
                        </div>
                    </div>
                    <div class="row align-items-center text-dark px-md-5 mb-3">
                        <div class="col-md-3 text-md-end">
                            <label for="input_invtax_name" class="col-form-label">ชื่อลูกค้า :</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="input_invtax_name" name="input_invtax_name" class="form-control " required value="<?= $row['invtax_name'] ?>">
                        </div>
                    </div>
                    <div class="row align-items-center text-dark px-md-5 mb-3">
                        <div class="col-md-3 text-md-end ">
                            <label for="input_invtax_address" class="col-form-label">ที่อยู่ :</label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" id="input_invtax_address" name="input_invtax_address" rows="3" required><?= $row['invtax_address']; ?></textarea>
                        </div>
                    </div>
                    <div class="row align-items-center text-dark px-md-5 mb-3">
                        <div class="col-md-3 text-md-end ">
                            <label for="input_invtax_cusid" class="col-form-label">เลขประจำตัวผู้เสียภาษี :</label>
                        </div>

                        <div class="col-md-8">
                            <input type="number" id="input_invtax_cusid" name="input_invtax_cusid" class="form-control " pattern="[0-9]{13}" title="กรุณากรอกตัวเลข 0-9 จำนวน 13 หลัก ไม่มี (-)" value="<?= $row['invtax_cusid'] ?>">
                        </div>
                    </div>
                    <div class="row align-items-center text-dark px-md-5 mb-3">
                        <div class="col-md-3 text-md-end ">
                            <label for="itemtitle" class="col-form-label">รายการใบแจ้งหนี้/ใบกำกับภาษี :</label>
                        </div>
                        <div class="border border-secondary rounded-3 py-md-4 px-md-4">
                            <div class="table-responsive">
                                <table id="invtax-item-table" class="table ">
                                    <tr>
                                        <th width="7%">ลำดับที่ <br>Number</th>
                                        <th width="40%">รายการ <br> Order </th>
                                        <th width="13%">จำนวน <br> Amount</th>
                                        <th width="15%">ราคา/หน่วย <br> Price/Unit</th>
                                        <th width="20%">จำนวนเงินรวม <br> Total</th>
                                        <th width="5%">ลบ</th>
                                    </tr>
                                    <?php

                                    $sql = "SELECT * FROM invoicetax_details WHERE invtaxd_tid ='$id'";
                                    $query = $conn->query($sql);
                                    $n = 0;
                                    while ($rows = $query->fetch_assoc()) {
                                        $n = $n + 1;
                                    ?>

                                        <tr id="row_id_<?= $n; ?>">
                                            <td><span id="sr_no"></span></td>
                                            <td>
                                                <input type="text" name="item_name[]" id="item_name<?= $n; ?>" class="form-control input-sm item_name" value="<?= $rows["invtaxd_item"]; ?>" required />
                                            </td>
                                            <td>
                                                <input type="number" name="item_amount[]" id="item_amount<?= $n; ?>" data-srno="<?= $n; ?>" class="form-control input-sm item_amount" value="<?= $rows["invtaxd_amount"]; ?>" required />
                                            </td>
                                            <td>
                                                <input type="number" name="item_price[]" id="item_price<?= $n; ?>" data-srno="<?= $n; ?>" class="form-control input-sm  item_price" value="<?= $rows["invtaxd_price"]; ?>" required />
                                            </td>
                                            <td>
                                                <input type="number" name="total_price[]" id="total_price<?= $n; ?>" data-srno="<?= $n; ?>" class="form-control input-sm total_price" value="<?= $rows["invtaxd_result"]; ?>" readonly />
                                            </td>
                                            <td>
                                                <button type="button" name="remove_row" id="<?= $n; ?>" class="btn btn-danger btn-xs remove_row">X</button>
                                            </td>
                                        </tr>

                                    <?php
                                    }
                                    ?>

                                </table>
                                <div class="text-center">
                                    <button type="button" id="add_row" class="btn btn-addpay px-md-4 rounded-3 " id="add_sub"><i class="fa fa-plus-circle text-white"></i> เพิ่มรายการ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex flex-row-reverse">
                        <div class="col-md-7">
                            <div class="row align-items-center text-dark px-md-5 mb-3">
                                <div class="col-md-6">
                                    <label for="input_invtax_sum" class="col-form-label">รวมเป็นเงิน(บาท) :</label>
                                </div>

                                <div class="col-md-6">
                                    <input type="number" id="input_invtax_sum" name="input_invtax_sum" class="form-control " placeholder="0.00" readonly value="<?= $row['invtax_sum'] ?>">
                                </div>
                            </div>
                            <div class="row align-items-center text-dark px-md-5 mb-3">
                                <div class="col-md-6 ">
                                    <label for="input_invtax_vat" class="col-form-label">ภาษีมูลค่าเพิ่ม 7%(บาท)
                                        :</label>
                                </div>

                                <div class="col-md-6">
                                    <input type="number" id="input_invtax_vat" name="input_invtax_vat" class="form-control " placeholder="0.00" readonly value="<?= $row['invtax_vat'] ?>">
                                </div>
                            </div>
                            <div class="row align-items-center text-dark px-md-5 mb-3">
                                <div class="col-md-6">
                                    <label for="input_invtax_total" class="col-form-label">จํานวนเงินรวมทั้งสิ้น(บาท)
                                        :</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" id="input_invtax_total" name="input_invtax_total" class="form-control " placeholder="0.00" readonly value="<?= $row['invtax_total'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn bg-secondary-addpay text-white me-3"><i class="fa-solid fa-eraser"></i> ล้างข้อมูล</button>
                                <button type="submit" name="action" value="edit_invoicetax" class="btn btn-addpay text-white">บันทึก <i class="fa-solid fa-cloud-arrow-up"></i></button>
                            </div>
                        </div>
                        <input type="hidden" name="total_item" id="total_item" value="<?= $n; ?>" />
                        <input type="hidden" name="invtax_no_check" id="invtax_no_check" value="<?= $row['invtax_no']; ?>" />
                        <input type="hidden" name="invtax_id" id="invtax_id" value="<?= $row['invtax_id']; ?>" />
                        <input type="hidden" name="invtax_date_create" id="invtax_date_create" value="<?= $row['invtax_create']; ?>" />
                    </div>

                </form>
                <script>
                    $(document).ready(function() {
                        var final_total_price = $('#final_total_price').text();
                        var count = <?= $n; ?>;
                        var total_item = <?= $n; ?>;

                        $(document).on('click', '#add_row', function() {
                            count++;
                            total_item++;
                            $('#total_item').val(total_item);
                            var html_code = '';
                            html_code += '<tr id="row_id_' + count + '">';
                            html_code += '<td><span id="sr_no"></span></td>';
                            html_code +=
                                '<td><input type="text" name="item_name[]" id="item_name' + count +
                                '" class="form-control input-sm" required/></td>';
                            html_code +=
                                '<td><input type="number" name="item_amount[]" id="item_amount' +
                                count + '" data-srno="' + count +
                                '" class="form-control input-sm number_only item_amount" required/></td>';
                            html_code +=
                                '<td><input type="number" name="item_price[]" id="item_price' +
                                count + '" data-srno="' + count +
                                '" class="form-control input-sm number_only item_price" required step="any"/></td>';
                            html_code +=
                                '<td><input type="number" name="total_price[]" id="total_price' +
                                count + '" data-srno="' + count +
                                '" class="form-control input-sm total_price" readonly /></td>';
                            html_code +=
                                '<td><button type="button" name="remove_row" id="' + count +
                                '" class="btn btn-danger btn-xs remove_row">X</button></td>';
                            html_code += '</tr>';
                            $('#invtax-item-table').append(html_code);
                        });

                        $(document).on('click', '.remove_row', function() {
                            var row_id = $(this).attr("id");
                            $('#row_id_' + row_id).remove();
                            total_item--;
                            $('#total_item').val(total_item);
                            cal_final_total(count);

                        });

                        function cal_final_total(count) {
                            var final_total_price = 0;
                            for (j = 1; j <= count; j++) {
                                var quantity = 0;
                                var price = 0;
                                var total_price = 0;
                                quantity = $('#item_amount' + j).val();
                                if (quantity > 0) {
                                    price = $('#item_price' + j).val();
                                    if (price > 0) {
                                        total_price = (parseFloat(quantity) * parseFloat(price));
                                        $('#total_price' + j).val(total_price.toFixed(2));

                                        final_total_price = (final_total_price + total_price);

                                    }
                                }
                            }
                            $('#input_invtax_sum').val(final_total_price.toFixed(2));

                            var vat7per = 0;
                            var summ = 0;
                            var aftervat = 0;

                            vat7per = (final_total_price * 0.07);
                            $('#input_invtax_vat').val(vat7per.toFixed(2));
                            aftervat = (vat7per + final_total_price);

                            $('#input_invtax_total').val(aftervat.toFixed(2));
                        }

                        $(document).on('change', '.item_price', function() {
                            cal_final_total(count);
                        });

                        $(document).on('change', '.item_amount', function() {
                            cal_final_total(count);
                        });


                    });
                </script>
            </div>
        </div>
    </div>
</div>
<?php $conn->close(); ?>