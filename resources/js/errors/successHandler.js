export function handleSuccessResponse(response) {
    if (response.status === 200) {
        this.loader(false);
        toastr.success(response.data.message);
    }
    if (response.status === 201) {
        this.loader(false);
        toastr.success(response.data.message);
    }
}
