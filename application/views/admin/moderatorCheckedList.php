<div class="main-content">
    <div class="wrap-content container" id="container">
        <!-- start: PAGE TITLE -->
        <section id="page-title">
            <div class="row">
                <div class="col-sm-8">
                    <h1 class="mainTitle">Moderator Details</h1>
                </div>
            </div>
        </section>

            <div class="panel panel-default">
                <a id="show-add-moderator" class="btn btn-green"><span class="fa fa-plus"></span>Add / Update Moderator</a>
                <br><br><br>
                <table id="tableModerator" class="display table table-striped">
                    <thead>
                    <tr>
                        <th>Moderator Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                    </tr>
                    </thead>
                    <tbody id="tableModeratorBody">
                    </tbody>
                </table>
            </div>
        </div>
</div>

<!-- Modal for Adding Default moderators Name-->
<div class="modal fade" id="addModerator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form name="frmAddModerator" id="frmAddModerator" action="<?= base_url() ?>/admin/sessions/addSelectedModerator"
              method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title text-center">Select Moderator</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="height: 400px; overflow-y: scroll">

                    <table id="addModeratorTable" class="table table-striped">
                        <thead>
                        <th><input type="checkbox" id="select_all">Select All</th>
                        <th>Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        </thead>
                        <tbody id="addModeratorBody" style="height: 400px; overflow-y: scroll">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input class="btn btn-success pull-right " id="saveModeratorBtn" type="submit" value="Save Changes">
                </div>
        </form>
    </div>
</div>
</div>
</div>

<link rel="stylesheet" href="@sweetalert2/themes/dark/dark.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        var selectedModerators = [];

        getSelectedModerators(selectedModerators);

        $('#show-add-moderator').on('click', function () {
            console.log(selectedModerators);
            getAllPresenters(selectedModerators);
            $('#addModerator').modal('show');
        })

        $('#addModerator #saveModeratorBtn').on('click', function (e) {
            e.preventDefault();

            let formData = new FormData(document.getElementById('frmAddModerator'));

            $.ajax({
                url: "<?=base_url()?>/admin/sessions/addSelectedModerator",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function (response) {
                    $('#addModerator').modal('hide');
                    Swal.fire(
                        'Moderator Updated!',
                        'Changes Saved',
                        'success'
                    )
                    getSelectedModerators(selectedModerators);
                }
            });
            selectedModerators = [];
        });

        $('#addModerator #select_all').on('click', function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        })
    });


    function getSelectedModerators(selectedModerators) {
        $.post("<?=base_url()?>/admin/sessions/getSelectedModerators",
            function (selected) {
                // console.log(selected);

                if ($.fn.DataTable.isDataTable('#tableModerator')) {
                    $('#tableModerator').DataTable().destroy();
                }

                $('#tableModeratorBody').html('');

                $.each(selected, function (i, mods) {

                    $('#tableModeratorBody').append('' +
                        '<tr>' +
                        '<td>' + mods.presenter_id + '</td>' +
                        '<td>' + mods.first_name + '</td>' +
                        '<td>' + mods.last_name + '</td>' +
                        '</tr>' +
                        '');
                    selectedModerators.push(mods.presenter_id);

                })

                $('#tableModerator').DataTable();

            }, 'json');
    }


    function getAllPresenters(selectedModerators) {

        $.post("<?=base_url()?>/admin/sessions/getPresentersJson",
            function (presenters) {

                // console.log(presenters);
                $('.modal-body #addModeratorBody').html('');

                $.each(presenters, function (index, presenter) {
                    if (selectedModerators.includes(presenter.presenter_id)) {
                        var chkStatus = "checked";
                    } else {
                        var chkStatus = '';
                    }
                    var checkBox = '<input id="selected_moderator[]" type="checkbox" data-presenter_id="' + presenter.presenter_id + '" value="' + presenter.presenter_id + '" name="selected_moderator[]" ' + chkStatus + '>';
                    // console.log(presenter);
                    $('.modal-body #addModeratorBody').append('' +
                        '<tr>' +
                        '<td>' + checkBox + '</td>' +
                        '<td>' + presenter.presenter_id + '</td>' +
                        '<td>' + presenter.first_name + '</td>' +
                        '<td>' + presenter.last_name + '</td>' +
                        '</tr>' +
                        '')
                })
                // console.log(presenters);
            }, 'json');
    }


</script>
