{{-- @extends('layouts.base')

@section('title', 'test title')


@section('content')
    <div>
        <p>Cat</p>
    </div>
@endsection


@section('scripts')
    <script>
        console.log('script is working');
    </script>
@endsection


 --}}


@extends('layouts.base')

@section('title', 'test title')


@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <!-- Button to open the modal -->
        <button id="openModalBtn" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
            Open Modal
        </button>
    </div>

    <!-- Modal backdrop (hidden by default) -->
    <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <!-- Modal content -->
        <div class="bg-white rounded-lg shadow-lg w-1/3">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-200 px-4 py-2 border-b">
                <h2 class="text-lg font-bold">Modal Title</h2>
                <button id="closeModalBtn" class="text-gray-500 hover:text-black">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="p-6">
                <p>This is the body of the modal.</p>
            </div>

            <!-- Modal footer -->
            <div class="flex justify-end p-4 border-t">
                <button id="closeModalFooterBtn" class="bg-red-500 text-white font-bold py-2 px-4 rounded">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Get elements
        // const openModalBtn = document.getElementById('openModalBtn');
        // const closeModalBtn = document.getElementById('closeModalBtn');
        // const closeModalFooterBtn = document.getElementById('closeModalFooterBtn');
        // const modal = document.getElementById('modal');

        // // Open modal event
        // openModalBtn.addEventListener('click', () => {
        //     modal.classList.remove('hidden');
        // });

        // // Close modal events
        // closeModalBtn.addEventListener('click', () => {
        //     modal.classList.add('hidden');
        // });

        // closeModalFooterBtn.addEventListener('click', () => {
        //     modal.classList.add('hidden');
        // });

        // // Optionally close the modal by clicking outside the modal content
        // window.addEventListener('click', (e) => {
        //     if (e.target === modal) {
        //         modal.classList.add('hidden');
        //     }
        // });

        $(document).ready(function() {
            // Open modal on button click
            $('#openModalBtn').click(function() {
                $('#modal').removeClass('hidden'); // Show modal backdrop
                $('#modalContent').css('animation', 'modalShow 0.3s forwards'); // Show modal with animation
            });

            // Close modal function
            function closeModal() {
                $('#modalContent').css('animation', 'modalHide 0.3s forwards'); // Hide modal with animation
                setTimeout(function() {
                    $('#modal').addClass('hidden'); // Hide modal backdrop after animation
                }, 300); // Matches the animation duration
            }

            // Close modal on close button click or footer button click
            $('#closeModalBtn, #closeModalFooterBtn').click(function() {
                closeModal();
            });

            // Close modal when clicking outside of modal content
            $(window).click(function(e) {
                if (e.target.id === 'modal') {
                    closeModal();
                }
            });
        });
    </script>
@endsection


@section('scripts')
    <script>
        console.log('script is working');
    </script>
@endsection























{{-- 
@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <!-- Button to open the modal -->
        <button id="openModalBtn" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
            Open Modal
        </button>
    </div>

    <!-- Modal backdrop (hidden by default) -->
    <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <!-- Modal content -->
        <div id="modalContent"
            class="bg-white rounded-lg shadow-lg w-1/3 transform scale-95 opacity-0 transition-all duration-300">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-200 px-4 py-2 border-b">
                <h2 class="text-lg font-bold">Modal Title</h2>
                <button id="closeModalBtn" class="text-gray-500 hover:text-black">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="p-6">
                <p>This is the body of the modal.</p>
            </div>

            <!-- Modal footer -->
            <div class="flex justify-end p-4 border-t">
                <button id="closeModalFooterBtn" class="bg-red-500 text-white font-bold py-2 px-4 rounded">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Animations -->
    <style>
        @keyframes modalShow {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes modalHide {
            from {
                transform: scale(1);
                opacity: 1;
            }

            to {
                transform: scale(0.95);
                opacity: 0;
            }
        }
    </style>

    <script>
        // Get elements
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const closeModalFooterBtn = document.getElementById('closeModalFooterBtn');
        const modal = document.getElementById('modal');
        const modalContent = document.getElementById('modalContent');

        // Open modal event
        openModalBtn.addEventListener('click', () => {
            modal.classList.remove('hidden'); // Show modal backdrop
            modalContent.style.animation = 'modalShow 0.3s forwards'; // Show modal with animation
        });

        // Close modal events
        const closeModal = () => {
            modalContent.style.animation = 'modalHide 0.3s forwards'; // Animate hide
            setTimeout(() => {
                modal.classList.add('hidden'); // Hide modal after animation
            }, 300); // Matches the animation duration
        };

        closeModalBtn.addEventListener('click', closeModal);
        closeModalFooterBtn.addEventListener('click', closeModal);

        // Optionally close the modal by clicking outside the modal content
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    </script>
@endsection --}}
