<?php

if(isset($_SESSION['toast'])):

$type = $_SESSION['toast']['type'];
$message = $_SESSION['toast']['message'];

$toastClass = "text-bg-success";

switch($type){

    case "danger":
        $toastClass = "text-bg-danger";
        break;

    case "warning":
        $toastClass = "text-bg-warning";
        break;

    case "info":
        $toastClass = "text-bg-info";
        break;

    default:
        $toastClass = "text-bg-success";
}

?>

<div class="toast-container position-fixed top-0 end-0 p-3">

<div
id="toastMessage"
class="toast <?php echo $toastClass; ?> border-0"
role="alert">

<div class="d-flex">

<div class="toast-body">

<?php echo htmlspecialchars($message); ?>

</div>

<button
type="button"
class="btn-close btn-close-white me-2 m-auto"
data-bs-dismiss="toast">
</button>

</div>

</div>

</div>

<script>

document.addEventListener("DOMContentLoaded",function(){

const toastElement=document.getElementById("toastMessage");

if(toastElement){

const toast=new bootstrap.Toast(toastElement,{
delay:3000
});

toast.show();

}

});

</script>

<?php

unset($_SESSION['toast']);

endif;

?>