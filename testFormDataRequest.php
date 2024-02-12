<script>
  let number = 5
  let actionValue = "HardYes"
  let url = "http://example.com"

  const formData = new FormData()
  formData.append("numInUniverse", number)
  formData.append("action", actionValue)
  formData.append("url", url)
  try {
    const res = fetch("/testFormDataRequest.php", {
     method: "POST",
     body: formData
    })
  } catch(err) {
    console.error("Doslo k chybe", err)
  }
  
</script>

<?php
// kdyz si otveres php log, najdes tam print techto promennych
error_log($_POST['url']);
error_log($_POST['action']);
error_log($_POST['numInUniverse']);
