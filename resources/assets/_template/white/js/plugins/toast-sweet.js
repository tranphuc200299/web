
const ToastSweetAlert = Swal.mixin({
    toast: true,
    position: 'center',
    showConfirmButton: false,
    timer: 3000
});

window.error = function (message) {
    ToastSweetAlert.fire({ type: 'error', title: message });
};
window.success = function (message) {
    ToastSweetAlert.fire({ type: 'success', title: message });
};
window.alert = function (message) {
    ToastSweetAlert.fire({ type: 'info', title: message });
};
