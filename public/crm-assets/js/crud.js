function post(url, data, buttonId, formId, redirectUrl) {
    let btn = document.getElementById(buttonId);
    btn.disabled = true;
    axios
        .post(url, data)
        .then((response) => {
            console.log(response);
            toastr.success(response.data.message);
            if (formId != undefined) {
                document.getElementById(formId).reset();
            }
            if (redirectUrl != undefined) {
                setTimeout(() => {
                    window.location.href = redirectUrl;
                }, 500);
            } else {
                btn.disabled = false;
            }
        })
        .catch((error) => {
            console.log(error);
            toastr.error(error.response.data.message);
            btn.disabled = false;
        });
}

function put(url, data, buttonId, formId, redirectUrl) {
    let btn = document.getElementById(buttonId);
    btn.disabled = true;
    axios
        .put(url, data)
        .then((response) => {
            console.log(response);
            toastr.success(response.data.message);
            if (formId != undefined) {
                document.getElementById(formId).reset();
            }
            if (redirectUrl != undefined) {
                setTimeout(() => {
                    window.location.href = redirectUrl;
                }, 500);
            } else {
                btn.disabled = false;
            }
        })
        .catch((error) => {
            console.log(error.response);
            toastr.error(error.response.data.message);
            btn.disabled = false;
        });
}

function get(url, buttonId, redirectUrl) {
    let btn = document.getElementById(buttonId);
    btn.disabled = true;
    axios
        .get(url)
        .then((response) => {
            console.log(response);
            toastr.success(response.data.message);
            if (redirectUrl != undefined) {
                setTimeout(() => {
                    window.location.href = redirectUrl;
                }, 500);
            } else {
                btn.disabled = false;
            }
        })
        .catch((error) => {
            console.log(error.response);
            toastr.error(error.response.data.message);
            btn.disabled = false;
        });
}

function confirmDelete(url, reference) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            deleteItem(url, reference);
        }
    });
}

function deleteItem(url, reference) {
    axios
        .delete(url)
        .then((response) => {
            reference.closest('tr').remove();
            showResponseMessage(response.data);
        })
        .catch((error) => {
            showResponseMessage(error.response.data);
        });
}

function showResponseMessage(data) {
    Swal.fire({
        title: data.title,
        text: data.text,
        icon: data.icon,
        showCancelButton: false,
        showConfirmButton: false,
        timer: 1500
    });
}
