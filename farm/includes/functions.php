<script>
function printTable() {
  
  var printContents = document.getElementById("dataTableHover").outerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
}

  </script>