<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import MenuIcon from '@/Components/Icons/MenuIcon.vue';
import LogoIcon from '@/Components/Icons/LogoIcon.vue';

// Handle sidebar toggle
const emit = defineEmits(['toggle-sidebar']);

// Handle user dropdown
const isDropdownOpen = ref(false);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};
</script>

<template>
    <nav class="bg-white border-b border-gray-200 px-4 py-2.5 fixed left-0 right-0 top-0 z-50">
        <div class="flex flex-wrap justify-between items-center">
            
            <!-- Left Side: Toggle Sidebar & Logo -->
            <div class="flex justify-start items-center">
                <button
                    @click="emit('toggle-sidebar')"
                    class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 transition-colors"
                >
                    <MenuIcon class="w-6 h-6" />
                    <span class="sr-only">Toggle sidebar</span>
                </button>
                
                <Link :href="route('admin.dashboard')" class="flex items-center justify-between mr-4 hover:opacity-80 transition-opacity">
                    <LogoIcon class="w-6 h-6 mr-2 text-gray-800" />
                    <span class="self-center text-xl font-bold whitespace-nowrap text-gray-900 tracking-tight">R.Ecom</span>
                </Link>
            </div>

            <!-- Right Side: User Menu -->
            <div class="flex items-center">
                <div class="relative">
                    <button
                        @click="toggleDropdown"
                        type="button"
                        class="flex items-center text-sm bg-gray-100 rounded-full focus:ring-4 focus:ring-gray-300 transition-shadow hover:bg-gray-200"
                        aria-expanded="false"
                    >
                        <span class="sr-only">Open user menu</span>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-800 text-white font-semibold text-xs">
                            <!-- Placeholder avatar initials -->
                            AD
                        </div>
                    </button>

                    <!-- User Dropdown Menu -->
                    <transition
                        enter-active-class="transition ease-out duration-100"
                        enter-from-class="transform opacity-0 scale-95"
                        enter-to-class="transform opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95"
                    >
                        <div
                            v-if="isDropdownOpen"
                            class="absolute right-0 z-50 mt-2 w-48 text-base list-none bg-white rounded-lg shadow-lg border border-gray-100 py-1"
                        >
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">Admin User</p>
                                <p class="text-xs font-medium text-gray-500 truncate">admin@recom.com</p>
                            </div>
                            
                            <ul class="py-1 text-gray-700">
                                <li>
                                    <Link 
                                        :href="route('profile.edit')" 
                                        class="block py-2 px-4 text-sm hover:bg-gray-50 hover:text-gray-900 transition-colors"
                                    >
                                        Profile Settings
                                    </Link>
                                </li>
                                <li>
                                    <Link 
                                        :href="route('logout')" 
                                        method="post" 
                                        as="button"
                                        class="block w-full text-left py-2 px-4 text-sm text-red-600 hover:bg-red-50 transition-colors"
                                    >
                                        Sign out
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </transition>
                </div>
            </div>
            
        </div>
    </nav>
</template>
