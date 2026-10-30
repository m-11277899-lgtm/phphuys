<?php # Butang saiz teks untuk jadual id='saiz' ?>
<span class="butang-saiz" style="font-size:14px;">
    Saiz Teks:
    <a href="#" onclick="subahsaiz(-1); return false;">[ A- ]</a>
    <a href="#" onclick="subahsaiz(1);  return false;">[ A+ ]</a>
</span>

<script>
function subahsaiz(arah) {
    var jadual = document.getElementById('saiz');
    if (!jadual) return;
    var semasa = parseFloat(window.getComputedStyle(jadual).fontSize) || 16;
    var baru = Math.min(24, Math.max(10, semasa + arah));
    jadual.style.fontSize = baru + 'px';
}
</script>
