<div x-data="progressBar()" class="w-full text-center px-12 py-8">
    <div class="relative flex items-center justify-between">
        <!-- Progress bar background -->
        <div class="absolute top-1/2 w-full h-4 bg-gray-300 rounded-full"></div>

        <!-- Progress bar fill -->
        <div class="absolute top-1/2 left-0 h-4 bg-green-500 rounded-full transition-all duration-1000" :style="'width: ' + progress + '%'" style="max-width: 100%;">
        </div>

        <!-- Mobil dengan posisi yang disesuaikan -->
        <div class="absolute top-[60%] transform -translate-x-1/2 -translate-y-1/2 transition-all duration-1000"
            :style="getCarPosition()">
            <img src="{{ asset('icons/car.svg') }}" class="w-24 h-24">
        </div>

        <!-- Checkpoints -->
        <div class="relative mt-4 z-10 flex w-full justify-between">
            <!-- Checkpoint 1 -->
            <div class="relative text-center cursor-pointer" @click="setProgress(0)">
                <i :class="progress >= 0 ? 'bx bxs-check-square text-green-500 -translate-y-7 transition duration-1000' : 'bx bxs-check-square text-gray-400 translate-y-0 transition duration-1000'"
                    class="text-4xl block transform"></i>
                <p :class="progress >= 0 ? 'text-green-500' : 'text-gray-400'" class="mt-2">Dalam Antrian</p>
            </div>

            <!-- Checkpoint 2 -->
            <div class="relative text-center cursor-pointer" @click="setProgress(1)">
                <i :class="progress === 50 ? 'bx bxs-check-square text-green-500 -translate-y-7 transition duration-1000' : 'bx bxs-check-square text-gray-400 translate-y-0 transition duration-1000'"
                    class="text-4xl block transform"></i>
                <p :class="progress >= 50 ? 'text-green-500' : 'text-gray-400'" class="mt-2">Sedang Diperbaiki</p>
            </div>

            <!-- Checkpoint 3 -->
            <div class="relative text-center cursor-pointer" @click="setProgress(2)">
                <i :class="progress === 100 ? 'bx bxs-check-square text-green-500 -translate-y-7 transition duration-1000' : 'bx bxs-check-square text-gray-400 translate-y-0 transition duration-1000'"
                    class="text-4xl block transform"></i>
                <p :class="progress >= 100 ? 'text-green-500' : 'text-gray-400'" class="mt-2">Selesai Perbaikan</p>
            </div>
        </div>
    </div>
</div>

<script>
    function progressBar() {
        return {
            progress: 10,

            setProgress(step) {
                this.progress = step * 50;
            },

            getCarPosition() {
                let position;
                if (this.progress === 0) {
                    position = '8%';  // Offset untuk posisi awal
                } else if (this.progress === 100) {
                    position = '92%';  // Offset untuk posisi akhir
                } else {
                    position = this.progress + '%';  // Posisi tengah
                }
                return `left: ${position}`;
            }
        }
    }
</script>