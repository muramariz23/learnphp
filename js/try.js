const tombolCari = document.querySelector('.cari');
const keyword = document.querySelector('.keyword');
const container = document.querySelector('.container');
//menghilangkan tombol cari
tombolCari.style.display = "none";
//event ketika kita menuliskan keyword
keyword.addEventListener('keyup', function() {
    //memakai ajax untuk liveSearch
    const xhr = new XMLHttpRequest();

    //contoh ajax cara lama
//     xhr.onreadystatechange = function() {
//         if(xhr.readyState == 4 && xhr.status == 200){
//             container.innerHTML = xhr.responseText;
//         }
//     };

//     xhr.open('get', 'ajax/ajax_cari.php?keyword=' + keyword.value);
//     xhr.send();

    //contoh ajax cara baru
    fetch('ajax/ajax_cari.php?keyword=' + keyword.value)
        .then((response) => response.text())
        .then((response) => (container.innerHTML = response));
 });

 //menambahkan fungsi preview image untuk file tambah dan file ubah
 function preview() {
    //untuk memilih gambar profile 
    const gambar = document.querySelector('.gambar');
    const imgPreview = document.querySelector('.img-preview');
    //untuk membaca file gambar profile yang di upload
    const oFReader = new FileReader();
    oFReader.readAsDataURL(gambar.files[0]);
    //untuk menggantikan image preview
    oFReader.onload = function (oFREvent) {
        imgPreview.src = oFREvent.target.result;
    };
}
 