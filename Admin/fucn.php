/*view*/
<?php
$conn;
function connect()
{
    $conn = mysqli_connect('localhost', 'huyviesea', 'huyviesea_db0', 'data_center') or die('Không thể kết nối!');
    mysqli_set_charset($conn, 'utf8');
    return $conn;
}

function disconnect($conn)
{
    mysqli_close($conn);
}
//sanphm,nhom
function type_product()
{

}
function product_view()
{

}
function type_customer()
{

}
function custumer_view()
{

}
function payment_view()
{

}
function type_user()
{
    $conn = connect();
    $sql = "SELECT role FROM users";
    $result = mysqli_query($conn, $sql);
    disconnect($conn);
}
function user_view()
{
    $conn = connect();
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    disconnect($conn);
    ?>
    <div class="view-table">
                <table id="table">
                    <thead>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr>
                            <th></th>
                        </tr>
                    </tbody>
                </table>
            </div>
    <?php
}
?>