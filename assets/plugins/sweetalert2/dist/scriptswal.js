const flashData = $('.flash-data').data('flashdata');
// console.log(flashData);
if (flashData == 'success') {
    Swal.fire({
       
        icon: 'success',
        title: '<h1>Pendaftaran Berhasil</h1>',
        html: '<h4>Data anda telah dikirim. <br>Silahkan cek email anda !</h4>',// add html attribute if you want or remove
        width: '500px',
        timer: 5000
    })
}

if (flashData == 'error') {
    Swal.fire({
        icon: 'error',
        title: '<h1>Mohon Maaf</h1>',
        text: 'keterangan data yang anda masukkan salah !',
        html: '<h4>keterangan data yang anda masukkan salah !!!</h4>',// add html attribute if you want or remove
        width: '500px',
        timer: 5000
    })
}
