 document.querySelectorAll('.toggle-password').forEach(toggle => {
 toggle.addEventListener('click', function() {
 const input = this.previousElementSibling;
 if (input.type === "password") {
 input.type = "text";
 this.textContent = "🙈";
 } else {
 input.type = "password";
 this.textContent = "👁️";
 }
 });
 });

 // Generate email otomatis
 function generateEmail() {
 const first = document.getElementById('first_name').value.trim();
 const last = document.getElementById('last_name').value.trim();
 if (first && last) {
 const email = ${first.toLowerCase()}${last.toLowerCase()}@student.bootcamp.com;
 document.getElementById('email').value = email;
 }
 }

 document.getElementById('first_name').addEventListener('input', generateEmail);
 document.getElementById('last_name').addEventListener('input', generateEmail);

 document.getElementById('pay-button').addEventListener('click', function() {
 const password = document.getElementById('password').value;
 const passwordConfirmation = document.getElementById('password_confirmation').value;

 if (password !== passwordConfirmation) {
 alert('Password tidak sama!');
 return;
 }
 const data = {
 first_name: document.getElementById('first_name').value,
 last_name: document.getElementById('last_name').value,
 email: document.getElementById('email').value,
 phone_number: document.getElementById('phone_number').value,
 address: document.getElementById('address').value,
 nik: document.getElementById('nik').value,
 course_id: document.getElementById('course_id').value,
 password: document.getElementById('password').value,
 };

 if (!data.course_id) {
 alert('Silakan pilih course terlebih dahulu.');
 return;
 }

 // Validasi sederhana
 for (const key in data) {
 if (!data[key]) {
 alert(Harap isi ${key.replace('_', ' ')} terlebih dahulu.);
 return;
 }
 }

 fetch("{{ route('demo.token') }}", {
 method: 'POST',
 headers: {
 'Content-Type': 'application/json',
 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
 'content')
 },
 body: JSON.stringify(data)
 })
 .then(async res => {
 if (!res.ok) {
 const errorData = await res.json();
 alert(errorData.error || 'Terjadi kesalahan.');
 return; // stop lanjut
 }
 return res.json();
 })
 .then(res => {
 if (res?.token) {
 snap.pay(res.token, {
 onSuccess: function(result) {
 fetch("{{ route('demo.callback') }}", {
 method: 'POST',
 headers: {
 'Content-Type': 'application/json',
 'X-CSRF-TOKEN': document.querySelector(
 'meta[name="csrf-token"]').getAttribute(
 'content')
 },
 body: JSON.stringify({
 ...data,
 midtrans_result: result
 })
 })
 .then(res => res.json())
 .then(data => {
 alert(
 'Terima kasih telah mendaftar! Pembayaran berhasil.'
 );
 });
 },
 onError: function(result) {
 alert('Terjadi error.');
 console.log(result);
 },
 onClose: function() {
 alert('Popup ditutup.');
 }
 });
 }
 });
 });
