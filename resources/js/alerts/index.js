import Swal from "sweetalert2";

export default {
    successAlert( message) {
        Swal.fire({
            position: "center",
            icon: "success",
            title: message,
            showConfirmButton: true,
            timer: 2000,
        });
    },
    warningAlert(message) {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: message,
            showConfirmButton: true,
            timer: 2000,
        });
    },
    errorAlert(message) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: message,
            showConfirmButton: true,
            timer: 2000,
        });
    },
};
