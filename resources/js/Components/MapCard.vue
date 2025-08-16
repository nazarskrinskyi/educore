<script setup>
defineProps({
    address: {
        type: String,
        required: true,
    },
    phone: {
        type: String,
        required: true,
    },
    mail: {
        type: String,
        required: true,
    },
    image: {
        type: String,
        required: true,
    },
    height: {
        type: String,
        default: '250px',
    },
    width: {
        type: String,
        default: '400px',
    },
});
</script>

<template>
    <div class="rounded-2xl overflow-hidden shadow-xl bg-white" :style="{ width }">
        <!-- Map Image -->
        <img
            :src="image"
            alt="Map Image"
            class="w-full object-cover"
            :style="{ height }"
        />

        <!-- Info section -->
        <div class="p-6 space-y-2 text-gray-800">
            <div>
                <p class="text-sm flex flex-row gap-2">
                  <span>
                    <svg width="16" height="22" viewBox="0 0 16 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8 0.5C3.85953 0.5 0.5 3.52391 0.5 7.25C0.5 13.25 8 21.5 8 21.5C8 21.5 15.5 13.25 15.5 7.25C15.5 3.52391 12.1405 0.5 8 0.5ZM8 11C7.40666 11 6.82664 10.8241 6.33329 10.4944C5.83994 10.1648 5.45542 9.69623 5.22836 9.14805C5.0013 8.59987 4.94189 7.99667 5.05764 7.41473C5.1734 6.83279 5.45912 6.29824 5.87868 5.87868C6.29824 5.45912 6.83279 5.1734 7.41473 5.05764C7.99667 4.94189 8.59987 5.0013 9.14805 5.22836C9.69623 5.45542 10.1648 5.83994 10.4944 6.33329C10.8241 6.82664 11 7.40666 11 8C10.9991 8.79538 10.6828 9.55794 10.1204 10.1204C9.55794 10.6828 8.79538 10.9991 8 11Z" fill="#0A2240"></path>
                    </svg>
                  </span>
                  {{ address }}
                </p>
            </div>
            <div>
                <p class="text-sm flex flex-row gap-2">
                  <span>
                    <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.5559 10.906L12.1009 11.359C12.1009 11.359 11.0179 12.435 8.06288 9.49701C5.10788 6.55901 6.19088 5.48301 6.19088 5.48301L6.47688 5.19701C7.18388 4.49501 7.25088 3.36701 6.63388 2.54301L5.37388 0.86001C4.60988 -0.15999 3.13488 -0.29499 2.25988 0.57501L0.68988 2.13501C0.25688 2.56701 -0.0331206 3.12501 0.00187944 3.74501C0.0918794 5.33201 0.809879 8.74501 4.81388 12.727C9.06088 16.949 13.0459 17.117 14.6749 16.965C15.1909 16.917 15.6389 16.655 15.9999 16.295L17.4199 14.883C18.3799 13.93 18.1099 12.295 16.8819 11.628L14.9719 10.589C14.1659 10.152 13.1859 10.28 12.5559 10.906Z" fill="#0A2240"></path>
                    </svg>
                  </span>
                    {{ phone }}
                </p>
            </div>
            <div>
                <p class="text-sm flex flex-row gap-2">
                  <span>
                    <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 4L10 9L2 4V2L10 7L18 2M18 0H2C0.89 0 0 0.89 0 2V14C0 14.5304 0.210714 15.0391 0.585786 15.4142C0.960859 15.7893 1.46957 16 2 16H18C18.5304 16 19.0391 15.7893 19.4142 15.4142C19.7893 15.0391 20 14.5304 20 14V2C20 1.46957 19.7893 0.960859 19.4142 0.585786C19.0391 0.210714 18.5304 0 18 0Z" fill="#0A2240"></path>
                    </svg>
                  </span>
                    {{ mail }}
                </p>
            </div>
        </div>

        <!-- Contact Button -->
        <div class="flex justify-center py-4">
            <button
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-full transition"
            >
                Contact Us
            </button>
        </div>
    </div>
</template>
