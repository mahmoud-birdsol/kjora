<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';


</script>
<template>
    <AppLayout :title="chat">
        <template #header>
            <p>chat</p>
        </template>
        <div>
            <div class="grid w-full h-full md:grid-cols-[1fr_2fr] text-center text-stone-500 bg-stone-300 rounded-lg ">
                <div class="md:border-r-2 md:border-r-stone-500 max-md:border-b-2 max-md:border-b-stone-500">sidebar
                </div>
                <div class="grid grid-row-[1fr_4fr_2fr]">
                    <!-- header -->
                    <div class="flex border-b-2 border-b-stone-500">
                        <div class="flex-1 border-r-2 border-r-stone-500">empty header </div>
                        <div>icons</div>
                    </div>
                    <div>
                        <div>date</div>
                        <div>
                            <h2>welcome to chat</h2>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos, corporis fugit nobis autem
                                necessitatibus dicta dolore, accusantium officia doloribus officiis corrupti est! Ab
                                repudiandae, delectus aliquid quam harum deserunt accusantium.</p>
                            <ul>
                                <li>
                                    <p>lorem5lorem5 lorem5lorem5 lorem5lorem5 lorem5lorem5 </p>
                                </li>
                                <li>
                                    <p>lorem5lorem5 lorem5lorem5 lorem5lorem5 lorem5lorem5 </p>
                                </li>
                                <li>
                                    <p>lorem5lorem5 lorem5lorem5 lorem5lorem5 lorem5lorem5 </p>
                                </li>
                                <li>
                                    <p>lorem5lorem5 lorem5lorem5 lorem5lorem5 lorem5lorem5 </p>
                                </li>
                                <li>
                                    <p>lorem5lorem5 lorem5lorem5 lorem5lorem5 lorem5lorem5 </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    this is empty div for acts like separation
                    <div class="h-2 border-y-2 border-y-stone-500">&nbsp;</div>
                    <div>footer</div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>


<style lang="scss" scoped>

</style>
