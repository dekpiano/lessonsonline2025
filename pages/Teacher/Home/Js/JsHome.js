$(function () {
    // กำหนดค่ามาตรฐานสำหรับ DataTable ในส่วนของ Home
    const commonConfig = {
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    };

    // ตารางสมาชิกทั้งหมด และ ตารางลงทะเบียนเรียน
    if ($('#Tb_ViewRegisterAll').length) {
        $("#Tb_ViewRegisterAll").DataTable({
            ...commonConfig,
            "order": [[3, 'desc']]
        }).buttons().container().appendTo('#Tb_ViewRegisterAll_wrapper .col-md-6:eq(0)');
    }

    // ตารางคอร์สเรียน และ ตารางบทเรียน
    if ($('#Tb_ViewLessons').length) {
        $("#Tb_ViewLessons").DataTable({
            ...commonConfig,
            "order": [[0, 'asc']]
        }).buttons().container().appendTo('#Tb_ViewLessons_wrapper .col-md-6:eq(0)');
    }

    // ตารางผู้เรียนที่สำเร็จการศึกษา
    if ($('#Tb_ViewGraduationAll').length) {
        $("#Tb_ViewGraduationAll").DataTable({
            ...commonConfig
        }).buttons().container().appendTo('#Tb_ViewGraduationAll_wrapper .col-md-6:eq(0)');
    }
});
