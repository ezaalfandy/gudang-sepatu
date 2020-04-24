
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 ml-auto mr-auto">
            <div class="card card-calendar">
                <div class="card-body ">
                    <div id="fullCalendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $pre_order = JSON.parse('<?= json_encode($data_pre_order);?>');
    $hand_over = JSON.parse('<?= json_encode($data_hand_over);?>');

    $color = ["#f56954", "#f39c12", "#0073b7", "#00c0ef", "#00a65a"];
    $event_kalendar_formatted = [];

    $.each($pre_order, function (i, v) {
        $data = {
            title           : 'PO - '+v.kode_pre_order,
            start           : new Date(v.tanggal_setor),
            end             : new Date(v.tanggal_setor),
            allDay          : true,
            url             : "<?= base_url('asisten-manager-gudang/view-detail-pre-order/')?>"+v.kode_pre_order,
            backgroundColor : '#1ec0d4'
        }         
        $event_kalendar_formatted.push($data);
    });

    $.each($hand_over, function (i, v) {
        $data = {
            title           : 'HO - '+v.kode_hand_over,
            start           : new Date(v.tanggal_dibuat),
            end             : new Date(v.tanggal_dibuat),
            allDay          : true,
            url             : "<?= base_url('asisten-manager-gudang/view-detail-hand-over/')?>"+v.kode_hand_over,
            backgroundColor : '#db2164'
        }         
        $event_kalendar_formatted.push($data);
    });

    $(document).ready(function () {
        md.initFullCalendar('#fullCalendar', $event_kalendar_formatted)
    });
</script>
            