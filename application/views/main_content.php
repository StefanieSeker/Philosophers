<script>
    function getPhilosopherDetail(id)
    {
        $.ajax({type : "GET",
            url : site_url + "/home/getAjaxPhilosopherDetail",
            data : { philosopherId : id },
            success : function(result){
                $("#result").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {

        $(".image").click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            getPhilosopherDetail(id);
            $('#myModal').modal('show');
        });
    });
</script>


<!--Banner-->
<div class="row">
    <div class="col-lg-12" id="banner_img">
        <div>
            <img src="<?php echo base_url('assets/images/SchoolOfPhilosophers.jpg'); ?>" alt="School Of Philosophers" width="100%"/>
        </div>
        <hr/>
    </div>
    <h3>Philosophers overview</h3>
</div>

<!--Philosophers images-->
<div class="row">
    <div class="col-lg-12">
        <?php foreach($philosophers as $philosopher){ ?>
            <img data-id="<?php echo $philosopher->ID;?>" class="image" src="<?php echo base_url('assets/images/'.$philosopher->Img); ?>" alt="<?php echo $philosopher->Name; ?>" width="20%"/>
        <?php } ?>
    </div>
</div>



<!--MODAL-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Philosopher detail</h4>
            </div>
            <div class="modal-body">
                <table>
                    <tbody id="result">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

