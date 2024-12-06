<x-app-layout>
    <div class="flex-wrap d-flex justify-content-between align-items-center">
        <h4 class="mb-2 fw-bold col-12 col-md-auto mb-md-0">Tambah Data Karyawan</h4>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary col-12 col-md-auto">Kembali</a>
    </div>

    <div class="mt-3 border bg-body-tertiary rounded-3">
        <div class="card">
            <form id="sendData">
                <div class="p-3 row">
                    <div class="col-lg-6 col-md-12">
                        <div class="flex-wrap d-flex align-items-center justify-content-center">
                            <div class="custom-dropzone" id="myDropzone">
                                <div class="dz-message">
                                    <div class="mb-1 icon">
                                        <i class="bi bi-cloud-arrow-up">
                                        </i>
                                    </div>
                                    <p><strong>Klik atau drag n drop untuk upload avatar.</strong></p>
                                </div>
                                <div id="deleting" style="display:none;" class="spinner-border text-primary"
                                    role="status"></div>
                            </div>
                            <input type="hidden" class="form-control" id="avatar" name="avatar">
                            <div class="mb-2 text-center invalid-feedback" id="error-avatar"></div>
                        </div>

                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Pegawai</label>
                            <input type="text" name="name" class="form-control" id="name">
                            <div class="invalid-feedback" id="error-name"></div>
                        </div>
                        <div class="mb-3">
                            <label for="hire_date" class="form-label">tanggal Masuk Kerja</label>
                            <input type="text" name="hire_date" class="form-control" id="hire_date">
                            <div class="invalid-feedback" id="error-hire_date"></div>
                        </div>
                        <div class="mb-3">
                            <label for="skills" class="form-label">Skills</label>
                            <select class="form-control" id="skills" name="skills[]" multiple="multiple">
                                <option>HTML</option>
                                <option>CSS</option>
                                <option>JavaScript</option>
                                <option>PHP</option>
                                <option>Laravel</option>
                                <option>React</option>
                            </select>
                            <div class="invalid-feedback" id="error-skills"></div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea rows="3" name="address" class="form-control" id="address"></textarea>
                            <div class="invalid-feedback" id="error-address"></div>
                        </div>
                    </div>
                </div>
                <div class="flex-wrap mb-3 d-flex justify-content-center items center">
                    <button type="submit" class="btn btn-success col-md-auto me-2">submit</button>
                    <div id="submitting" style="display:none;" class="spinner-border text-success" role="status"></div>
                </div>
            </form>

        </div>
    </div>

    @push('scripts')
        <script>
            $('#hire_date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2018,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'DD/MM/YYYY'
                }
            })
            $('#skills').select2({
                placeholder: "Pilih Skills",
                allowClear: true,
                tags: true
            });
            $("#myDropzone").dropzone({
                url: '/upload',
                paramName: "file",
                maxFilesize: 2,
                maxFiles: 1,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                init: function() {
                    this.on("sending", function(file, xhr, formData) {
                        formData.append('_token', '{{ csrf_token() }}');
                    });
                    this.on("success", function(file, response) {
                        console.log("File uploaded successfully:", response);
                        file.path = response.path;
                        $(".dz-message").fadeOut();
                        $('input[name="avatar"]').val(file.path);
                    });
                    this.on("removedfile", function(file) {
                        $(".spinner-border").show();
                        if (file.xhr) {
                            const path = JSON.parse(file.xhr.response).path;
                            fetch('/delete', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: JSON.stringify({
                                    path: path
                                }),
                            }).then((response) => {
                                console.log("File deleted successfully");
                            }).catch((error) => {
                                console.error("Error deleting file:", error);
                            }).finally(() => {
                                $("#deleting").hide();
                                $(".dz-message").fadeIn();
                            });
                        }
                    });
                }
            })

            $(document).ready(function() {
                $('#sendData').submit(function(e) {
                    e.preventDefault();
                    $("#submitting").show();

                    const data = $(this).serialize();
                    $.ajax({
                        url: '{{ route('employees.store') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        data: data,
                        success: function(response) {
                            $("#submitting").hide();
                            Swal.fire({
                                title: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/employees';
                            });
                        },
                        error: function(xhr) {
                            $("#submitting").hide();
                            let errors = xhr.responseJSON.errors;
                            console.log(errors);
                            for (const key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    $(`#error-${key}`).text(errors[key][0]);
                                    $(`#${key}`).addClass('is-invalid');
                                }
                            }
                        }
                    })
                })
            })
        </script>
    @endpush
</x-app-layout>
