     </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript" src="libs/js/functions.js"></script>
  <script>
      var e_nominal = document.getElementById('e_nominal');
		e_nominal.addEventListener('keyup', function(e){
			e_nominal.value = formatRupiah(this.value, 'Rp. ');
		});

    var e_ppn = document.getElementById('e_ppn');
		e_ppn.addEventListener('keyup', function(e){
			e_ppn.value = formatRupiah(this.value, 'Rp. ');
		});

    var e_pph = document.getElementById('e_pph');
		e_pph.addEventListener('keyup', function(e){
			e_pph.value = formatRupiah(this.value, 'Rp. ');
		});

   

  /* Fungsi formatRupiah */
  function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }
  
  </script>
  </body>

  
<script type="text/javascript">


  
  var rupiah = document.getElementById('rupiah');
  rupiah.addEventListener('keyup', function(e){
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah.value = formatRupiah1(this.value, 'Rp. ');
  });

  var pph = document.getElementById('pph');
		pph.addEventListener('keyup', function(e){
			// tambahkan 'Rp.' pada saat form di ketik
			// gunakan fungsi formatpph() untuk mengubah angka yang di ketik menjadi format angka
			pph.value = formatRupiah1(this.value, 'Rp. ');
		});

    var ppn = document.getElementById('ppn');
		ppn.addEventListener('keyup', function(e){
			ppn.value = formatRupiah1(this.value, 'Rp. ');
		});

    /* Fungsi formatRupiah */
  function formatRupiah1(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }

  
</script>

</html>

<?php if(isset($db)) { $db->db_disconnect(); } ?>
