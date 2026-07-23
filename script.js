$(document).ready(function () {

    $("#loading").hide();

    $("#resumePdf").change(function () {
        let file = this.files[0];

        if (file) {
            $("#selectedFile").text("Selected PDF: " + file.name);
        } else {
            $("#selectedFile").text("No PDF selected");
        }
    });

    $("#analyzeBtn").click(function () {

        let resume = $("#resume").val().trim();
        let pdfFile = $("#resumePdf")[0].files[0];

        if (resume == "" && !pdfFile) {

            alert("Please upload a resume PDF or paste your resume text.");

            return;

        }

        if (pdfFile && pdfFile.type !== "application/pdf") {
            alert("Please upload only PDF file.");
            return;
        }

        let formData = new FormData();
        formData.append("resume", resume);

        if (pdfFile) {
            formData.append("resume_pdf", pdfFile);
        }


        $("#loading").show();

        $("#result").html("Generating AI Response...");

        $.ajax({

            url: "analyze.php",
            type: "POST",
            data: formData,

            processData: false,

            contentType: false,



            success: function (response) {

                $("#loading").hide();

                $("#result").html(response);

            },




            error: function (xhr) {

                $("#loading").hide();
                $("#result").html(xhr.responseText || "Something went wrong.");

            }

        });

    });

});
