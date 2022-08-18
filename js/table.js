// jQuery(document).ready(function($){
//     var dt = $('#example').DataTable({    
//         ajax: {
//             url: "/wp-admin/admin-ajax.php?action=datatables_endpoint",
//             cache:false,
//         },
//         columns: [
//             { data: 'ID' },        
//             { data: 'post_title' },        
//         ],
//         pageLength: 25
//     }); //.DataTable()
// });

jQuery(document).ready(function($){
    $('#example').DataTable();
} );