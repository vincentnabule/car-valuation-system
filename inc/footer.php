<footer>
    <div class="cRights d-block not-printed">
        <div class="container blackBGy bg-light">
            <p class="text-dark"><i>© <?= date('Y') ?> Copyright.</i><br>
                Terms and Conditions apply.
            </p>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/index.js"></script>
<script>
    $('.my-valuation').click(function() {
        $('.info_pop').removeClass('d-none');
        $('.more-valuation').prop('hidden', true);
    });

    function showmodels(str) {
        $("#c_mdl").prop('disabled', false);
        console.log(str);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("models").innerHTML = this.responseText;
                console.log(responseText);
            }
        };

        xmlhttp.open("GET", "models.php?q=" + str, true);
        xmlhttp.send();
    }
</script>


</body>

</html>