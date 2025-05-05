import './bootstrap';
// import Echo from 'laravel-echo';

// // Inisialisasi Echo dengan Redis
// window.Echo = new Echo({
//     broadcaster: 'redis',
//     host: window.location.hostname + ':6001'  // Pastikan port sesuai dengan yang ada di server
// });

// // Mendengarkan event di 'staff-channel'
// Echo.channel('staff-channel')
//     .listen('MessageSent', (event) => {
//         console.log('Pesan baru untuk staff:', event.message);
//     });

// // Mendengarkan event di 'owner-channel'
// Echo.channel('owner-channel')
//     .listen('MessageSent', (event) => {
//         console.log('Pesan baru untuk owner:', event.message);
//     });