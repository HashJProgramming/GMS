const urlParams = new URLSearchParams(window.location.search);
const type = urlParams.get('type');
const message = urlParams.get('message');
if (type == 'success') {
    swal("Success!", message, "success");
} else if (type == 'error') {
    swal("Error!", message, "error");
}