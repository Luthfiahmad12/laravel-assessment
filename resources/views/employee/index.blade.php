<x-app-layout>
    <div class="flex-wrap d-flex justify-content-between align-items-center">
        <h3 class="mb-2 fw-bold col-12 col-md-auto mb-md-0">Data Karyawan</h3>
        <a href="{{ route('employees.create') }}" class="btn btn-success col-12 col-md-auto">Tambah Data</a>
    </div>

    <div class="mt-3 border bg-body-tertiary rounded-3">
        <div class="p-3 table-responsive">
            <table id="datatable" class="table text-capitalize table-bordered dataTable display" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>avatar</th>
                        <th>nama</th>
                        <th>alamat</th>
                        <th>tanggal bekerja</th>
                        <th>keahlian</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $item => $employee)
                        <tr>
                            <td>{{ $item + 1 }}</td>
                            <td>
                                <img src="{{ filter_var($employee->avatar, FILTER_VALIDATE_URL) ? $employee->avatar : Storage::url($employee->avatar) }}"
                                    width="45px" alt="">
                            </td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->address }}</td>
                            <td>{{ $employee->hire_date }}</td>
                            <td>{{ $employee->skills }}</td>
                            <td>
                                <div class="gap-2 d-flex justify-content-center">
                                    <button onclick="edit()" class="btn btn-md btn-primary">
                                        Edit
                                    </button>
                                    <button onclick="destroy({{ $employee->id }})" class="btn btn-md btn-danger">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            $("#datatable").DataTable({
                responsive: true,
                lengthMenu: [
                    [5, 10, 15, 25, 50, -1],
                    [5, 10, 15, 25, 50, "All"]
                ],
                language: {
                    search: "Cari :",
                    lengthMenu: " _MENU_ Paginasi Data per Halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                }
            });

            function edit() {
                Swal.fire({
                    title: "INFO",
                    text: 'Sayangnya fitur ini belum tersedia :(',
                    icon: 'warning',
                    customClass: {
                        confirmButton: "btn btn-success",
                    },
                    confirmButtonText: 'SIAP'
                })
            }

            function destroy(id) {
                // console.log(id);

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: true
                });
                swalWithBootstrapButtons.fire({
                    title: "Apakah kamu yakin ingin hapus data ini?",
                    text: "data yang dihapus tidak dapat kembali",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Kembali",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('employees.destroy', '') }}/${id}`,
                            type: "POST",
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                swalWithBootstrapButtons.fire({
                                    title: "Dihapus!",
                                    text: "Data berhasil dihapus!",
                                    icon: "success"
                                }).then(() => {
                                    window.location.reload();
                                });
                            }
                        })
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Batal",
                            text: "Data kamu aman :)",
                            icon: "error"
                        });
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
