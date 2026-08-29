<style>
.icons-footer {
    color: white;
    font-size: 14px;
    background-color: #212425;
    border-radius: 50%;
    padding: 10px;
}
.align-reverse {
    align-items: start;
}
@media (max-width:768px) {
    .align-reverse {
    align-items: center;
}
}
</style>
<template>
    <div class="rodape footer pb-32 md:pb-5 mt-5 footer-color p-4 md:p-8">
        <div class="m-auto flex flex-col">
            <div class="w-full flex flex-col-reverse md:flex-row gap-4 justify-between items-center">
                
                <div class="flex flex-col align-reverse" style="">

                <a v-if="setting" href="/" class="flex justify-center items-center">
                    <img style="max-width: 170px;" :src="`/storage/`+setting.software_logo_black" alt="" class="h-10 block dark:hidden " />
                    <img style="max-width: 170px;" :src="`/storage/`+setting.software_logo_white" alt=""  class="h-10 hidden dark:block" />
                    
                </a>
                <div v-if="custom" class="flex  mt-2">
                            <div v-if="custom.instagram" class="flex">
                                <a :href="custom.instagram" target="_blank" class="text-2xl p-1">
                                    <i class="fa-brands fa-instagram icons-footer" style="color: #00FF5A;"></i>
                                </a>
                            </div>
                            <div v-if="custom.telegram" class="flex">
                                <a :href="custom.telegram" target="_blank" class="text-2xl p-1">
                                    <i class="fa-brands fa-telegram icons-footer" style="color: #00FF5A;"></i>
                                </a>
                            </div>
                            <div v-if="custom.whastapp" class="flex">
                                <a :href="custom.whastapp" target="_blank" class="text-2xl p-1">
                                    <i class="fa-brands fa-whatsapp icons-footer" style="color: #00FF5A;"></i>
                                </a>
                            </div>
                            <div v-if="custom.facebook" class="flex">
                                <a :href="custom.facebook" target="_blank" class="text-2xl p-1">
                                    <i class="fa-brands fa-facebook icons-footer" style="color: #00FF5A;"></i>
                                </a>
                            </div>
                            <div v-if="custom.youtube" class="flex">
                                <a :href="custom.youtube" target="_blank" class="text-2xl p-1">
                                    <i class="fa-brands fa-youtube icons-footer" style="color: #00FF5A;"></i>
                                </a>
                            </div>
                            </div>
</div>             
              
              <footer class="bg-[#e7e8e900] text-top text-white py-8">
  <div class="container mx-auto px-4 grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-6 text-sm">
    <!-- Apostas -->
    <div>
      <h3 class="font-semibold" style="font-size: 14px;">Aposte</h3>
      <ul class="mt-2 space-y-1">
        <li><a href="#" class="text-[#adadad] hover:text-white">Apostas Esportivas</a></li>
        <li><a href="#" class="text-[#adadad] hover:text-white">Esportes ao Vivo</a></li>
        <li><a href="#" class="text-[#adadad] hover:text-white">Jogos Slots</a></li>
        <li><a href="#" class="text-[#adadad] hover:text-white">Jogos ao Vivo</a></li>
      </ul>
    </div>

    <!-- Comunidade -->
    <div>
      <h3 class="font-semibold" style="font-size: 14px;">Comunidade</h3>
      <ul class="mt-2 space-y-1">
        <li><a href="#" class="text-[#adadad] hover:text-white">Promoções</a></li>
        <li><a href="#" class="text-[#adadad] hover:text-white">Blog</a></li>
        <li><a href="#" class="text-[#adadad] hover:text-white">Central de Ajuda</a></li>
        <li><a href="#" class="text-[#adadad] hover:text-white">Canais de Atendimento</a></li>
      </ul>
    </div>

    <!-- Regras -->
    <div>
      <h3 class="font-semibold" style="font-size: 14px;">Regras</h3>
      <ul class="mt-2 space-y-1">
        <li><a href="#" class="text-[#adadad] hover:text-white">Termos de Apostas</a></li>
        <li><a href="#" class="text-[#adadad] hover:text-white">Termos e Condições</a></li>
        <li><a href="#" class="text-[#adadad] hover:text-white">Política de Privacidade</a></li>
        <li><a href="#" class="text-[#adadad] hover:text-white">Jogo Responsável</a></li>
      </ul>
    </div>

    <!-- Links Úteis -->
    <div>
      <h3 class="font-semibold" style="font-size: 14px;">Links Úteis</h3>
      <div data-v-b2b8e498="" class="flex flex-col items-start gap-3 mt-2">
        <a data-v-b2b8e498="" href="/contact" class="contactButton" style="background-color: #00ff5a; color: #1a1a2e; padding: 1px 7px; border-radius: 25px; text-decoration: none; display: flex; align-items: center; gap: 8px; font-weight: 600; font-size: 13px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 255, 90, 0.3);">
            <span data-v-b2b8e498="" class="nuxt-icon nuxt-icon--fill buttonIcon">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.5416 21.7865C21.5753 21.9386 21.5747 22.0964 21.5397 22.2483C21.5048 22.4002 21.4365 22.5424 21.3397 22.6646C21.2429 22.7868 21.1202 22.8859 20.9803 22.9547C20.8405 23.0236 20.6871 23.0604 20.5312 23.0625C20.3704 23.0616 20.2119 23.0242 20.0677 22.9531L18.2239 22.0521C16.5009 22.6813 14.6141 22.6998 12.8791 22.1044C11.1442 21.509 9.66626 20.3359 8.69269 18.7812C9.99712 18.9504 11.3225 18.8431 12.5828 18.4664C13.8431 18.0898 15.01 17.4521 16.0077 16.5949C17.0053 15.7377 17.8115 14.6802 18.3737 13.491C18.9359 12.3019 19.2415 11.0077 19.2708 9.69271C19.2713 9.096 19.2103 8.50083 19.0885 7.91666C20.3356 8.52155 21.3961 9.45212 22.158 10.61C22.9198 11.7679 23.3547 13.1101 23.4166 14.4948C23.4579 15.5447 23.28 16.5917 22.8945 17.5691C22.5089 18.5465 21.924 19.4329 21.1771 20.1719L21.5416 21.7865Z" fill="currentColor" fill-opacity="0.5"></path>
                    <path d="M9.89583 1.5625C7.71384 1.53816 5.61124 2.3801 4.04908 3.90369C2.48692 5.42729 1.5927 7.50819 1.5625 9.69011C1.56176 10.7979 1.79279 11.8935 2.24074 12.9066C2.6887 13.9198 3.34366 14.828 4.16354 15.5729L3.82813 17.3635C3.80021 17.5139 3.80566 17.6685 3.84408 17.8166C3.8825 17.9646 3.95296 18.1023 4.05048 18.2201C4.148 18.3379 4.2702 18.4329 4.40845 18.4982C4.54669 18.5636 4.6976 18.5978 4.85052 18.5984C5.02346 18.5981 5.19362 18.555 5.34583 18.4729L7.31875 17.413C8.15173 17.6802 9.02105 17.8169 9.89583 17.8182C12.0779 17.8426 14.1806 17.0006 15.7428 15.4769C17.3049 13.9532 18.1991 11.8721 18.2292 9.69011C18.199 7.50819 17.3047 5.42729 15.7426 3.90369C14.1804 2.3801 12.0778 1.53816 9.89583 1.5625ZM6.77084 10.9375C6.56481 10.9375 6.36342 10.8764 6.19212 10.762C6.02081 10.6475 5.8873 10.4848 5.80846 10.2945C5.72962 10.1041 5.70899 9.89468 5.74918 9.69262C5.78938 9.49055 5.88859 9.30495 6.03427 9.15927C6.17995 9.01359 6.36555 8.91438 6.56762 8.87418C6.76968 8.83399 6.97912 8.85462 7.16946 8.93346C7.3598 9.0123 7.52249 9.14582 7.63695 9.31712C7.75141 9.48842 7.8125 9.68981 7.8125 9.89584C7.8125 10.1721 7.70275 10.4371 7.5074 10.6324C7.31205 10.8278 7.0471 10.9375 6.77084 10.9375ZM9.89583 10.9375C9.68981 10.9375 9.48842 10.8764 9.31712 10.762C9.14581 10.6475 9.0123 10.4848 8.93346 10.2945C8.85462 10.1041 8.83399 9.89468 8.87418 9.69262C8.91438 9.49055 9.01359 9.30495 9.15927 9.15927C9.30495 9.01359 9.49055 8.91438 9.69262 8.87418C9.89468 8.83399 10.1041 8.85462 10.2945 8.93346C10.4848 9.0123 10.6475 9.14582 10.7619 9.31712C10.8764 9.48842 10.9375 9.68981 10.9375 9.89584C10.9375 10.1721 10.8278 10.4371 10.6324 10.6324C10.4371 10.8278 10.1721 10.9375 9.89583 10.9375ZM13.0208 10.9375C12.8148 10.9375 12.6134 10.8764 12.4421 10.762C12.2708 10.6475 12.1373 10.4848 12.0585 10.2945C11.9796 10.1041 11.959 9.89468 11.9992 9.69262C12.0394 9.49055 12.1386 9.30495 12.2843 9.15927C12.4299 9.01359 12.6156 8.91438 12.8176 8.87418C13.0197 8.83399 13.2291 8.85462 13.4195 8.93346C13.6098 9.0123 13.7725 9.14582 13.8869 9.31712C14.0014 9.48842 14.0625 9.68981 14.0625 9.89584C14.0625 10.1721 13.9528 10.4371 13.7574 10.6324C13.5621 10.8278 13.2971 10.9375 13.0208 10.9375Z" fill="currentColor"></path>
                </svg>
            </span> 
            Contate-nos
        </a>
      </div>
    </div>

    <!-- Pagamento e Segurança -->
    <div>
      <h3 class="font-semibold" style="font-size: 14px;">Pagamento</h3>
      <svg style="max-width: 70px;" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 952.8 338.7">
                        <path class="cls-1" fill="#32bcad" d="M638.9,34.8l-11.3-11.3c-2.8-2.8-2.8-7.3,0-10.1,0,0,0,0,0,0l11.3-11.3c2.8-2.8,7.3-2.8,10.2,0l11.3,11.3c2.8,2.8,2.8,7.3,0,10.1,0,0,0,0,0,0l-11.3,11.3c-2.8,2.8-7.3,2.8-10.1,0,0,0,0,0,0,0M246.1,264.5c-12.3,0-24.1-4.8-32.8-13.5l-47.4-47.4c-3.5-3.3-9-3.3-12.4,0l-47.5,47.5c-8.7,8.7-20.5,13.6-32.8,13.6h-9.3l60,60c18.7,18.7,49.1,18.7,67.8,0l60.1-60.1h-5.8ZM73.3,97.1c12.3,0,24.1,4.9,32.8,13.6l47.5,47.5c3.4,3.4,9,3.4,12.4,0l47.3-47.3c8.7-8.7,20.5-13.6,32.8-13.6h5.7l-60.1-60.1c-18.7-18.7-49.1-18.7-67.8,0,0,0,0,0,0,0l-59.9,59.9h9.3ZM301.6,147l-36.3-36.3c-.8.3-1.7.5-2.6.5h-16.5c-8.6,0-16.8,3.4-22.9,9.5l-47.3,47.3c-8.9,8.9-23.3,8.9-32.1,0l-47.5-47.5c-6.1-6.1-14.3-9.5-22.9-9.5h-20.3c-.8,0-1.7-.2-2.4-.5l-36.6,36.5c-18.7,18.7-18.7,49.1,0,67.8l36.5,36.5c.8-.3,1.6-.5,2.4-.5h20.4c8.6,0,16.8-3.4,22.9-9.5l47.5-47.5c8.6-8.6,23.6-8.6,32.1,0l47.3,47.3c6.1,6.1,14.3,9.5,22.9,9.5h16.5c.9,0,1.8.2,2.6.5l36.3-36.3c18.7-18.7,18.7-49.1,0-67.8,0,0,0,0,0,0"></path>
                        <path class="cls-2" fill="#f9f9f9" d="M582.8,122v41.3c0,39-31.7,70.7-70.7,70.7h-81.1c-3.3,0-6-2.7-6-6s2.7-6,6-6h81.1c32.4,0,58.7-26.4,58.7-58.8v-41.3c0-32.3-26.3-58.6-58.5-58.7h-57.3c-32.4,0-58.7,26.3-58.7,58.7v194.3c0,3.3-2.7,6-6,6s-6-2.7-6-6V122c0-39,31.7-70.7,70.7-70.7h57.4c38.9.2,70.5,31.8,70.4,70.7ZM617.7,51.3h-24.9c-3.3,0-6,2.7-6,6s2.7,6,6,6h24.9c11.4,0,20.6,9.2,20.6,20.6v145.1c0,3.3,2.7,6,6,6s6-2.7,6-6V83.8c0-17.9-14.6-32.5-32.5-32.5ZM692,63.1h24.7c11.2,0,21.7,4.4,29.6,12.3l57.7,57.7c4.7,4.7,11,7.4,17.8,7.3,6.7,0,13-2.6,17.7-7.3l57.6-57.6c7.9-7.9,18.4-12.3,29.6-12.3h20.1c3.3,0,6-2.7,6-6s-2.7-6-6-6h-20.1c-14.4,0-27.9,5.6-38,15.7l-57.5,57.5c-5.1,5.1-13.5,5.1-18.6,0l-57.7-57.7c-10.2-10.2-23.7-15.7-38.1-15.7h-24.7c-3.3,0-6,2.7-6,6s2.7,6,6,6ZM946.7,221.5h-20.1c-11.2,0-21.7-4.4-29.6-12.3l-57.5-57.5c-9.8-9.8-25.7-9.8-35.5,0l-57.7,57.7c-7.9,7.9-18.4,12.3-29.6,12.3h-24.7c-3.3,0-6,2.7-6,6s2.7,6,6,6h24.7c14.4,0,27.9-5.6,38-15.7l57.7-57.7c5.1-5.1,13.5-5.1,18.6,0l57.5,57.5c10.2,10.2,23.7,15.7,38,15.7h20.1c3.3,0,6-2.7,6-6s-2.7-6-6-6ZM442.5,299.8c4.5,0,6.8,2.2,6.8,7.1s-2.8,7.2-8.8,7.2c-2.4,0-4.7-.4-6.9-1.2v-11.8c2.9-.8,5.9-1.2,8.9-1.4M433.7,321.7v-6.9c2.3.7,4.7,1.1,7.1,1.1,2.4,0,4.8-.5,6.9-1.5,2.8-1.6,3.8-4.6,3.8-7.5s-.7-5.6-2.7-7.3c-1.8-1.3-3.9-1.9-6.1-1.8-3.1.2-6.2.7-9.3,1.5l-.2-1h-1.6v23.4h2ZM466.4,299.7c5.9,0,8.5,2.3,8.5,7.4s-2.6,7.1-8.5,7.1-8.6-2.3-8.6-7.3,2.6-7.1,8.6-7.1M474,314.1c2.2-1.5,3-4.1,3-7.2s-.8-5.6-3-7.2c-2-1.4-4.6-1.8-7.6-1.8s-5.7.4-7.7,1.8c-2.2,1.6-3.1,4-3.1,7.2s.9,5.7,3.1,7.2c1.9,1.4,4.6,1.8,7.7,1.8s5.6-.4,7.6-1.8M503.9,315.5l7.1-17.1h-2.2l-5.7,14.4h-.1l-6.5-14.4h-1.8l-6.4,14.4h-.1l-5.9-14.4h-2.2l7,17.1h1.8l6.5-14.2h.1l6.6,14.2h1.8ZM523.8,299.6c5.5,0,7.5,2.1,7.7,6h-15.4c.3-3.5,2.2-6,7.7-6M523.7,315.9c3,0,6-.4,9-1v-1.8c-2.9.6-5.9.9-8.8,1-6.7,0-7.8-3.1-7.9-6.6h17.5c0-3.3-.5-6.2-3-7.9-2.1-1.2-4.5-1.8-6.8-1.7-2.4-.1-4.7.5-6.7,1.7-2.3,1.7-3.2,4.4-3.2,7.3s.7,5.4,2.7,7.1c1.7,1.4,3.8,1.9,7.1,1.9M541.3,315.4v-14.4c3.8-1,5.4-1.4,8.1-1.4h.5v-1.9h-.2c-3.2,0-4.9.6-8.5,1.5l-.2-1h-1.6v17.1h2ZM561.5,299.6c5.5,0,7.5,2.1,7.7,6h-15.4c.3-3.5,2.2-6,7.7-6M561.4,315.9c3,0,6-.4,9-1v-1.8c-2.9.6-5.9.9-8.9,1-6.7,0-7.8-3.1-7.9-6.6h17.6c0-3.3-.5-6.2-3-7.9-2.1-1.2-4.5-1.8-6.8-1.7-2.4-.1-4.7.5-6.7,1.7-2.3,1.7-3.2,4.4-3.2,7.3s.7,5.4,2.7,7.1c1.7,1.4,3.8,1.9,7.1,1.9M593.2,312.7c-2.9.7-5.9,1.2-8.9,1.3-4.5,0-6.8-2.2-6.8-7.1s2.8-7.2,8.8-7.2c2.4,0,4.7.4,6.9,1.1v11.9ZM595.2,315.5v-24.4h-2v7.8c-2.3-.7-4.7-1-7.1-1.1-2.4,0-4.8.5-6.9,1.6-2.8,1.6-3.8,4.4-3.8,7.5s.7,5.6,2.7,7.2c1.7,1.3,3.9,1.9,6.1,1.8,3.1-.2,6.2-.7,9.3-1.5l.2,1h1.6ZM624.5,299.8c4.5,0,6.8,2.2,6.8,7.1s-2.8,7.2-8.8,7.2c-2.4,0-4.7-.4-6.9-1.2v-11.8c2.9-.8,5.9-1.2,8.9-1.4M629.7,314.4c2.8-1.6,3.8-4.6,3.8-7.5s-.7-5.6-2.7-7.3c-1.8-1.3-3.9-1.9-6.1-1.8-3.1.2-6.1.7-9.1,1.4v-8.2h-2v24.3h1.4v-.8c2.6.8,5.2,1.3,7.8,1.3,2.4,0,4.7-.5,6.9-1.5M636.1,322c.8.1,1.6.2,2.5.2,3.5,0,5.4-1.2,7.2-4.6l9.6-19.2h-2.3l-7.3,14.8h-.1l-7.7-14.8h-2.3l9,17.1-.7,1.4c-1.4,2.8-2.9,3.5-5.4,3.5s-1.5,0-2.5-.2v1.9M683,305.7c4,0,6.3.3,6.3,3s-1.7,3-6.3,3h-6.6v-6h6.6M681.8,296c4.1,0,6.3.3,6.3,3s-1.8,3.1-6.3,3.1h-5.5v-6.1h5.4M692.1,313.8c1.7-1,2.6-2.8,2.5-4.7,0-3.3-1.9-4.8-4.9-5.5h0c2.7-1.2,3.7-2.9,3.7-5.3.1-1.9-.8-3.7-2.4-4.6-2.4-1.4-5.2-1.5-9.9-1.5h-9.9v23.3h10.2c5.4,0,8.3,0,10.8-1.6M714.8,311.6c-2.4.6-4.8.9-7.2,1-2.7,0-3.7-.7-3.7-2.3s1.2-2.3,4.7-2.3,4.2,0,6.2.3v3.3ZM719.7,315.5v-10.1c0-2.5-.4-4.5-2.3-5.9s-5-1.6-8-1.6-5,.1-7.4.3v3.5c2.2-.2,4.5-.3,6.3-.3,4.8,0,6.6.9,6.6,3.6v.3c-2-.1-4.4-.2-6.2-.2s-4.6,0-6.4.9c-.6.3-1.2.8-1.7,1.3-1.9,2.2-1.6,5.6.7,7.5,1.6.9,3.4,1.4,5.2,1.3,3.1-.1,6.3-.6,9.3-1.5v1c.1,0,4,0,4,0ZM746.7,315.5v-10.5c0-2.4-.5-4.1-1.9-5.4-1.7-1.3-3.8-1.9-5.9-1.8-3.1.2-6.2.7-9.2,1.6l-.2-1.1h-3.9v17.1h4.8v-12.6c2.3-.6,4.6-1,7-1.1,2.8,0,4.4,1.1,4.4,4.2v9.5h4.7ZM760.2,315.9c2.8,0,5.6-.5,8.3-1.1v-3.5c-2.4.5-4.8.8-7.2.9-3.7,0-5.3-1.6-5.3-5.3s2.1-5.4,6.7-5.4,3.7.1,5.5.3v-3.7c-2.1-.2-4-.3-6-.3s-5.4.3-7.5,1.7c-2.6,1.7-3.5,4.6-3.5,7.3s.6,5.6,2.7,7.3c1.8,1.5,4.2,1.8,6.4,1.8M782.7,301.4c4.5,0,6.5,1.7,6.5,5.6s-1.9,5.3-6.5,5.3-6.5-1.7-6.5-5.6,2-5.3,6.5-5.3M790.9,314.1c2.3-1.6,3.2-4.2,3.2-7.3s-.8-5.7-3.2-7.2c-2.1-1.4-4.8-1.8-8.2-1.8s-6.2.4-8.2,1.8c-2.4,1.6-3.2,4.2-3.2,7.3s.8,5.7,3.2,7.2c2.1,1.4,4.9,1.8,8.2,1.8s6.1-.4,8.2-1.8M821.7,315.9c3.8-.1,7.5-.6,11.2-1.5v-4.1c-3.4.8-6.9,1.3-10.3,1.4-4.9,0-7.5-2.5-7.5-7.9s2.8-7.9,9.4-7.9,5.4.2,7.9.4v-4.2c-2.9-.2-5.5-.4-8.1-.4s-7,.4-9.8,2.2c-3.6,2.4-4.7,6.4-4.7,9.9s.8,7.4,3.6,9.7c2.3,1.9,5.5,2.4,8.3,2.4M847,300.9c4,0,5.6,1.2,5.7,4h-11.5c.3-2.6,1.8-4,5.8-4M846.3,315.9c3.5,0,6.9-.5,10.3-1.1v-3.4c-3,.5-6.1.8-9.1.9-4.8,0-6.2-1.7-6.3-4.3h16.3c0-3.5-.2-6.5-3-8.4-2.1-1.5-5-1.7-7.4-1.7s-5.4.3-7.5,1.8c-2.4,1.7-3.2,4.6-3.2,7.2s.8,5.6,2.8,7.2,4.5,1.9,7.3,1.9M883.5,315.5v-10.5c0-2.4-.5-4.1-1.9-5.4-1.7-1.3-3.8-1.9-5.9-1.8-3.1.2-6.2.7-9.2,1.6l-.2-1.1h-3.9v17.1h4.8v-12.6c2.3-.6,4.6-1,7-1.1,2.8,0,4.4,1.1,4.4,4.2v9.5h4.7ZM897.1,315.9c1.7,0,3.3-.3,5-.6v-3.4c-1.1.2-2.3.3-3.4.3-1.5,0-2.6-.4-3.1-1.6-.4-1-.5-2.2-.5-3.3v-5.5h6.8v-3.6h-6.8v-5.2h-4.2l-.5,5.2h-3.5v3.6h3.5v6.4c-.1,1.8.3,3.6,1.3,5.2,1.2,1.8,3.2,2.5,5.6,2.5M911.2,315.5v-12.6c2.2-.6,4.5-.9,6.7-.9h1.7v-4.1c-.2,0-.4,0-.6,0-2.9.1-5.7.6-8.5,1.6l-.2-1.1h-3.9v17.1h4.8ZM937,311.6c-2.4.6-4.8.9-7.2,1-2.7,0-3.7-.7-3.7-2.3s1.2-2.3,4.7-2.3,4.2,0,6.2.3v3.3ZM941.8,315.5v-10.1c0-2.5-.4-4.5-2.3-5.9s-5-1.6-8-1.6-5,.1-7.4.3v3.5c2.2-.2,4.4-.3,6.3-.3,4.8,0,6.6.9,6.6,3.6v.3c-2-.1-4.4-.2-6.2-.2s-4.6,0-6.4.9c-1.8.8-3,2.6-2.9,4.6,0,1.6.6,3.2,1.9,4.1,1.6.9,3.4,1.4,5.2,1.3,3.1-.1,6.3-.6,9.3-1.5v1c.1,0,3.9,0,3.9,0ZM947.9,315.5h4.8v-24.4h-4.8v24.4Z"></path>
                    </svg>
      <h3 class="font-semibold mt-4">Regulamento e Segurança</h3>
      <p class="mt-2 text-gray-400">Apenas maiores de 18 anos podem se cadastrar. Jogue com responsabilidade.</p>
    </div>
  </div>
</footer>
            </div>
            <div class="flex flex-col border-y-[1px] border-[#5B5E5F] my-[40px] text-center text-base">
                <p class="pt-[20px]" style="font-size: 12px;">
                 
                          Uma Experiência Emocionante e Segura.

Somos um site de apostas esportivas e cassino online, que oferece aos seus usuários uma experiência única de apostas em diversos esportes, incluindo futebol, basquete, tênis, vôlei, entre outros. Com uma plataforma intuitiva e fácil de usar, permitimos que seus usuários apostem em jogos ao vivo, além de oferecer uma ampla variedade de opções de apostas pré-jogo.
                </p>
                <template v-if="expanded">
                    <p style="font-size: 12px;">
                        

Com o objetivo de proporcionar a melhor experiência de apostas aos seus usuários, oferecemos uma ampla gama de recursos e ferramentas, incluindo estatísticas detalhadas dos jogos, histórico de resultados, análises de especialistas e muito mais. Além disso, o site oferece diversas promoções e bônus exclusivos para seus usuários, aumentando as chances de lucro e proporcionando uma experiência ainda mais emocionante.

Somos uma plataforma segura e confiável, que oferece suporte ao cliente 24 horas por dia, sete dias por semana. Com uma equipe de especialistas em apostas esportivas e cassino online, estamos comprometidos em garantir que seus usuários tenham uma experiência positiva e segura, e possam desfrutar de todas as emoções e oportunidades oferecidas pelas apostas esportivas de forma responsável e consciente.
                    </p>
                </template>
                <div class="flex justify-center items-center mt-2 mb-4 w-full" style="background: linear-gradient(to bottom, rgb(33 36 37 / 0%), var(--footer-color-dark));">
                    <button @click.prevent="toggleExpanded" class="px-4 flex justify-center items-center text-center " style="opacity: .8;">
                        <p class="text-white text-xs">{{ expanded ? 'Ver menos' : 'Ver mais' }}</p>
                    </button>
                </div>
            </div>
            <div class="flex justify-center items-center text-center flex-col border-[#ffffff]">
               <div class="text-base text-white pt-[12px]"><img alt="BRA" style="max-width: 10%;display: inline;margin-bottom: 5px;border-radius: 10px;" loading="lazy" data-nuxt-img="" srcset="https://static.donald.bet.br/deploy-61c28dd36f668578d879809687eeaa2a20cc50d0-88272fd7186e84093a64/assets/images/countries/BRA.png 1x, https://static.donald.bet.br/deploy-61c28dd36f668578d879809687eeaa2a20cc50d0-88272fd7186e84093a64/assets/images/countries/BRA.png 2x" class="AlabW" src="https://static.donald.bet.br/deploy-61c28dd36f668578d879809687eeaa2a20cc50d0-88272fd7186e84093a64/assets/images/countries/BRA.png">
    Feito com 💚 para Brasileiros!
</div>

            </div>
            <div class="flex flex-col-reverse md:flex-row items-center justify-center gap-2 border-y-[1px] border-[#5B5E5F] my-[40px] text-center text-base py-[20px]">
                <div class="w-[100%] md:w-[80%]">
                    <p style="font-size: 12px;line-height: 15px;" class="pt-[20px]"><strong>LUCKYBET </strong>é um site de entretenimento online que oferece aos seus usuários uma experiência única em apostas esportivas e jogos online. Este site é operado pela <strong>BETGAMING DESENVOLVIMENTO DE TECNOLOGIAS SA</strong>, uma empresa registrada no Brasil, sob o número <strong>CNPJ 74.214.124/0001-30</strong>, com sede em AV PAULISTA, 1106 SALA 02 ANDAR 14 - CEP 03.538-060 - BELA VISTA - SÃO PAULO/SP, entidade devidamente autorizada a operar a modalidade lotérica de apostas de quota fixa no Brasil, em temática desportiva e jogos online, conjuntamente, pela Secretaria de Prêmios e Apostas do Ministério da Fazenda, conforme Portaria SPA/MF n.º 2090/2024, publicada em 31 de dezembro de 2024 no Diário Oficial da República Federativa do Brasil.

Ao acessar, continuar a usar ou navegar neste site, você concorda que podemos usar determinados cookies do navegador para melhorar sua experiência ao usar nosso site. Utilizamos cookies apenas para melhorar a sua experiência e isso não interfere na sua privacidade.<br></p>
                </div>
                <div class="w-[180px] h-[51px]">
                    <img src="https://static.donald.bet.br/deploy-61c28dd36f668578d879809687eeaa2a20cc50d0-88272fd7186e84093a64/assets/seals/autorizado.png" alt="GAMING LICENSEE CLICK FOR MORE INFORMATION" >
                </div>
            </div>
            <div class="flex flex-col justify-center items-center">
                <div class="flex flex-row items-center justify-center gap-4">
                    <div class="w-[160px] h-[48px] flex justify-center items-center">
                        <img src="https://i.imgur.com/JFMlh7p.png" alt="BeGambleAware">
                    </div>
                    <div class="w-[55px] h-[48px] flex justify-center items-center">
                        <img src="https://i.postimg.cc/q7LY2tX4/gt-logo.png" alt="BeGambleAware">
                    </div>
                  	<div class="w-[55px] h-[48px] flex justify-center items-center">
                  		<img alt="Reclame Aqui" class="pBDYo" src="https://acqualimp.com/wp-content/uploads/2018/06/imagens_blog_800x600-5.jpeg" title="Reclame Aqui">
                  	</div>
                    <svg fill="none" height="40px" viewBox="0 0 200 200" width="40px" xmlns="https://i.postimg.cc/g2dH3GzK/Dls2-Y6-OXg-AA2-fb.png" class="parent-advisor" title="Para maiores de 18 anos"><circle cx="100" cy="100" fill="currentColor" r="100"></circle><circle cx="99.9231" cy="99.9231" fill="black" r="76.9231"></circle><path d="M45 91.304V76.2294C53.0312 74.8205 58.788 70.3122 62.2706 62.7044H72.7182V136.951H58.6459V84.4007C55.803 87.3123 51.2544 89.6134 45 91.304Z" fill="white"></path><path d="M82.9527 97.0803C78.9726 93.4173 76.9826 88.2985 76.9826 81.7239C76.9826 76.5581 78.5462 72.0028 81.6733 68.058C84.8716 64.0193 89.7756 62 96.3853 62C102.711 62 107.508 63.9724 110.777 67.9172C114.118 71.768 115.788 76.3702 115.788 81.7239C115.788 88.2985 113.798 93.4173 109.818 97.0803C115.575 101.213 118.453 107.365 118.453 115.536C118.453 122.205 116.428 127.793 112.377 132.301C108.325 136.716 102.995 138.923 96.3853 138.923C89.7045 138.923 84.3386 136.669 80.2874 132.161C76.3074 127.652 74.3174 122.111 74.3174 115.536C74.3174 111.122 75.1702 107.365 76.876 104.265C78.5817 101.072 80.6073 98.677 82.9527 97.0803ZM96.3853 91.5858C98.02 91.5858 99.477 90.9753 100.756 89.7543C102.036 88.4394 102.675 86.5139 102.675 83.978C102.675 81.3482 102.036 79.3758 100.756 78.0609C99.477 76.7459 98.02 76.0885 96.3853 76.0885C94.7507 76.0885 93.2581 76.7459 91.9078 78.0609C90.6285 79.3758 89.9888 81.3482 89.9888 83.978C89.9888 86.42 90.6285 88.2985 91.9078 89.6134C93.2581 90.9283 94.7507 91.5858 96.3853 91.5858ZM96.3853 124.271C98.8018 124.271 100.721 123.379 102.142 121.594C103.635 119.81 104.381 117.509 104.381 114.691C104.381 111.685 103.599 109.243 102.036 107.365C100.543 105.393 98.6596 104.406 96.3853 104.406C94.0399 104.406 92.121 105.393 90.6285 107.365C89.1359 109.243 88.3897 111.685 88.3897 114.691C88.3897 117.603 89.1004 119.951 90.5219 121.735C92.0144 123.426 93.9689 124.271 96.3853 124.271Z" fill="white"></path><path d="M143.66 85.0769V84.0769H142.66H138.264H137.264V85.0769V97.3553H125.077H124.077V98.3553V102.659V103.659H125.077H137.264V115.846V116.846H138.264H142.66H143.66V115.846V103.659H155.846H156.846V102.659V98.3553V97.3553H155.846H143.66V85.0769Z" fill="white" stroke="white" stroke-width="2"></path></svg>
                </div>  
                <!-- <LanguageSelector /> -->
                <div class="mt-[15px] gap-2 px-4 flex justify-center items-center text-center py-2 bg-[#fdffff0d] border-1 border-[#585c5c]" style="border-radius: 5px;">
                    <svg style="font-size: 12px;" data-v-1c71b597="" id="flag-icons-br" height="16px" viewBox="0 0 640 480" width="16px" xmlns="http://www.w3.org/2000/svg" class="flag"><g stroke-width="1pt"><path d="M0 0h640v480H0z" fill="#229e45" fill-rule="evenodd"></path><path d="m321.4 436 301.5-195.7L319.6 44 17.1 240.7 321.4 436z" fill="#f8e509" fill-rule="evenodd"></path><path d="M452.8 240c0 70.3-57.1 127.3-127.6 127.3A127.4 127.4 0 1 1 452.8 240z" fill="#2b49a3" fill-rule="evenodd"></path><path d="m283.3 316.3-4-2.3-4 2 .9-4.5-3.2-3.4 4.5-.5 2.2-4 1.9 4.2 4.4.8-3.3 3m86 26.3-3.9-2.3-4 2 .8-4.5-3.1-3.3 4.5-.5 2.1-4.1 2 4.2 4.4.8-3.4 3.1m-36.2-30-3.4-2-3.5 1.8.8-3.9-2.8-2.9 4-.4 1.8-3.6 1.6 3.7 3.9.7-3 2.7m87-8.5-3.4-2-3.5 1.8.8-3.9-2.7-2.8 3.9-.4 1.8-3.5 1.6 3.6 3.8.7-2.9 2.6m-87.3-22-4-2.2-4 2 .8-4.6-3.1-3.3 4.5-.5 2.1-4.1 2 4.2 4.4.8-3.4 3.2m-104.6-35-4-2.2-4 2 1-4.6-3.3-3.3 4.6-.5 2-4.1 2 4.2 4.4.8-3.3 3.1m13.3 57.2-4-2.3-4 2 .9-4.5-3.2-3.3 4.5-.6 2.1-4 2 4.2 4.4.8-3.3 3.1m132-67.3-3.6-2-3.6 1.8.8-4-2.8-3 4-.5 1.9-3.6 1.7 3.8 4 .7-3 2.7m-6.7 38.3-2.7-1.6-2.9 1.4.6-3.2-2.2-2.3 3.2-.4 1.5-2.8 1.3 3 3 .5-2.2 2.2m-142.2 50.4-2.7-1.5-2.7 1.3.6-3-2.1-2.2 3-.4 1.4-2.7 1.3 2.8 3 .6-2.3 2M419 299.8l-2.2-1.1-2.2 1 .5-2.3-1.7-1.6 2.4-.3 1.2-2 1 2 2.5.5-1.9 1.5" fill="#ffffef" fill-rule="evenodd"></path><path d="m219.3 287.6-2.7-1.5-2.7 1.3.6-3-2.1-2.2 3-.4 1.4-2.7 1.3 2.8 3 .6-2.3 2" fill="#ffffef" fill-rule="evenodd"></path><path d="m219.3 287.6-2.7-1.5-2.7 1.3.6-3-2.1-2.2 3-.4 1.4-2.7 1.3 2.8 3 .6-2.3 2m42.3 3-2.6-1.4-2.7 1.3.6-3-2.1-2.2 3-.4 1.4-2.7 1.3 2.8 3 .5-2.3 2.1m-4.8 17-2.6-1.5-2.7 1.4.6-3-2.1-2.3 3-.4 1.4-2.7 1.3 2.8 3 .6-2.3 2m87.4-22.2-2.6-1.6-2.8 1.4.6-3-2-2.3 3-.3 1.4-2.7 1.2 2.8 3 .5-2.2 2.1m-25.1 3-2.7-1.5-2.7 1.4.6-3-2-2.3 3-.3 1.4-2.8 1.2 2.9 3 .5-2.2 2.1m-68.8-5.8-1.7-1-1.7.8.4-1.9-1.3-1.4 1.9-.2.8-1.7.8 1.8 1.9.3-1.4 1.3m167.8 45.4-2.6-1.5-2.7 1.4.6-3-2.1-2.3 3-.4 1.4-2.7 1.3 2.8 3 .6-2.3 2m-20.8 6-2.2-1.4-2.3 1.2.5-2.6-1.7-1.8 2.5-.3 1.2-2.3 1 2.4 2.5.4-1.9 1.8m10.4 2.3-2-1.2-2.1 1 .4-2.3-1.6-1.7 2.3-.3 1.1-2 1 2 2.3.5-1.7 1.6m29.1-22.8-2-1-2 1 .5-2.3-1.6-1.7 2.3-.3 1-2 1 2.1 2.1.4-1.6 1.6m-38.8 41.8-2.5-1.4-2.7 1.2.6-2.8-2-2 3-.3 1.3-2.5 1.2 2.6 3 .5-2.3 1.9m.6 14.2-2.4-1.4-2.4 1.3.6-2.8-1.9-2 2.7-.4 1.2-2.5 1.1 2.6 2.7.5-2 2m-19-23.1-1.9-1.2-2 1 .4-2.2-1.5-1.7 2.2-.2 1-2 1 2 2.2.4-1.6 1.6m-17.8 2.3-2-1.2-2 1 .5-2.2-1.6-1.7 2.3-.2 1-2 1 2 2.1.4-1.6 1.6m-30.4-24.6-2-1.1-2 1 .5-2.3-1.6-1.6 2.2-.3 1-2 1 2 2.2.5-1.6 1.5m3.7 57-1.6-.9-1.8.9.4-2-1.3-1.4 1.9-.2.9-1.7.8 1.8 1.9.3-1.4 1.3m-46.2-86.6-4-2.3-4 2 .9-4.5-3.2-3.3 4.5-.6 2.2-4 1.9 4.2 4.4.8-3.3 3.1" fill="#ffffef" fill-rule="evenodd"></path><path d="M444.4 285.8a124.6 124.6 0 0 0 5.8-19.8c-67.8-59.5-143.3-90-238.7-83.7a124.5 124.5 0 0 0-8.5 20.9c113-10.8 196 39.2 241.4 82.6z" fill="#fff" fill-rule="evenodd"></path><path d="m414 252.4 2.3 1.3a3.4 3.4 0 0 0-.3 2.2 3 3 0 0 0 1.4 1.7c.7.5 1.4.8 2 .7.6 0 1-.3 1.3-.7a1.3 1.3 0 0 0 .2-.9 2.3 2.3 0 0 0-.5-1c-.2-.3-.7-1-1.5-1.8a7.7 7.7 0 0 1-1.8-3 3.7 3.7 0 0 1 2-4.4 3.8 3.8 0 0 1 2.3-.2 7 7 0 0 1 2.6 1.2c1.4 1 2.3 2 2.6 3.2a4.1 4.1 0 0 1-.6 3.3l-2.4-1.5c.3-.6.4-1.2.2-1.7-.1-.5-.5-1-1.2-1.4a3.2 3.2 0 0 0-1.8-.7 1 1 0 0 0-.9.5c-.2.3-.2.6-.1 1s.6 1.2 1.6 2.2c1 1 1.6 1.9 2 2.5a3.9 3.9 0 0 1-.3 4.2 4.1 4.1 0 0 1-1.9 1.5 4 4 0 0 1-2.4.3c-.9-.2-1.8-.6-2.8-1.3-1.5-1-2.4-2.1-2.7-3.3a5.4 5.4 0 0 1 .6-4zm-11.6-7.6 2.5 1.3a3.4 3.4 0 0 0-.2 2.2 3 3 0 0 0 1.4 1.6c.8.5 1.4.7 2 .6.6 0 1-.3 1.3-.8a1.3 1.3 0 0 0 .2-.8c0-.3-.2-.7-.5-1a34.6 34.6 0 0 0-1.6-1.8c-1.1-1.1-1.8-2-2-2.8a3.7 3.7 0 0 1 .4-3.1 3.6 3.6 0 0 1 1.6-1.4 3.8 3.8 0 0 1 2.2-.3 7 7 0 0 1 2.6 1c1.5 1 2.4 2 2.7 3.1a4.1 4.1 0 0 1-.4 3.4l-2.5-1.4c.3-.7.4-1.2.2-1.7s-.6-1-1.3-1.4a3.2 3.2 0 0 0-1.9-.6 1 1 0 0 0-.8.5c-.2.3-.2.6-.1 1s.7 1.2 1.7 2.2c1 1 1.7 1.8 2 2.4a3.9 3.9 0 0 1 0 4.2 4.2 4.2 0 0 1-1.8 1.6 4 4 0 0 1-2.4.3 8 8 0 0 1-2.9-1.1 6 6 0 0 1-2.8-3.2 5.4 5.4 0 0 1 .4-4zm-14.2-3.8 7.3-12 8.8 5.5-1.2 2-6.4-4-1.6 2.7 6 3.7-1.3 2-6-3.7-2 3.3 6.7 4-1.2 2-9-5.5zm-20.7-17 1.1-2 5.4 2.7-2.5 5c-.8.2-1.8.3-3 .2a9.4 9.4 0 0 1-3.3-1 7.7 7.7 0 0 1-3-2.6 6 6 0 0 1-1-3.5 8.6 8.6 0 0 1 1-3.7 8 8 0 0 1 2.6-3 6.2 6.2 0 0 1 3.6-1.1c1 0 2 .3 3.2 1 1.6.7 2.6 1.7 3.1 2.8a5 5 0 0 1 .3 3.5l-2.7-.8a3 3 0 0 0-.2-2c-.3-.6-.8-1-1.6-1.4a3.8 3.8 0 0 0-3.1-.3c-1 .3-1.9 1.2-2.6 2.6-.7 1.4-1 2.7-.7 3.8a3.7 3.7 0 0 0 2 2.4c.5.3 1.1.5 1.7.5a6 6 0 0 0 1.8 0l.8-1.6-2.9-1.5zm-90.2-22.3 2-14 4.2.7 1.1 9.8 3.9-9 4.2.6-2 13.8-2.7-.4 1.7-10.9-4.4 10.5-2.7-.4-1.1-11.3-1.6 11-2.6-.4zm-14.1-1.7 1.3-14 10.3 1-.2 2.4-7.5-.7-.3 3 7 .7-.3 2.4-7-.7-.3 3.8 7.8.7-.2 2.4-10.6-1z" fill="#309e3a"></path><g stroke-opacity=".5"><path d="M216.5 191.3c0-1.5.3-2.6.7-3.6a6.7 6.7 0 0 1 1.4-1.9 5.4 5.4 0 0 1 1.8-1.2c1-.3 2-.5 3-.5 2.1 0 3.7.8 5 2a7.4 7.4 0 0 1 1.6 5.5c0 2.2-.7 4-2 5.3a6.5 6.5 0 0 1-5 1.7 6.6 6.6 0 0 1-4.8-2 7.3 7.3 0 0 1-1.7-5.3z" fill="#309e3a"></path><path d="M219.4 191.3c0 1.5.3 2.7 1 3.6.7.8 1.6 1.3 2.8 1.3a3.5 3.5 0 0 0 2.8-1.1c.7-.8 1-2 1.1-3.7 0-1.6-.2-2.8-1-3.6a3.5 3.5 0 0 0-2.7-1.3 3.6 3.6 0 0 0-2.8 1.2c-.8.8-1.1 2-1.2 3.6z" fill="#f7ffff"></path></g><g stroke-opacity=".5"><path d="m233 198.5.2-14h6c1.5 0 2.5.2 3.2.5.7.2 1.2.7 1.6 1.3s.6 1.4.6 2.3a3.8 3.8 0 0 1-1 2.6 4.5 4.5 0 0 1-2.7 1.2l1.5 1.2c.4.4.9 1.2 1.5 2.3l1.7 2.8h-3.4l-2-3.2-1.4-2a2.1 2.1 0 0 0-.9-.6 5 5 0 0 0-1.4-.2h-.6v5.8H233z" fill="#309e3a"></path><path d="M236 190.5h2c1.4 0 2.3 0 2.6-.2.3 0 .6-.3.8-.5s.3-.7.3-1c0-.6-.1-1-.4-1.2-.2-.3-.6-.5-1-.6h-2l-2.3-.1v3.5z" fill="#fff"></path></g><g stroke-opacity=".5"><path d="m249 185.2 5.2.3c1.1 0 2 .1 2.6.3a4.7 4.7 0 0 1 2 1.4 6 6 0 0 1 1.2 2.4c.3.9.4 2 .3 3.3a9.3 9.3 0 0 1-.5 3c-.4 1-1 1.8-1.7 2.4a5 5 0 0 1-2 1c-.6.2-1.5.2-2.5.2l-5.3-.3.7-14z" fill="#309e3a"></path><path d="m251.7 187.7-.5 9.3h3.8c.5 0 .9-.2 1.2-.5.3-.3.6-.7.8-1.3.2-.6.4-1.5.4-2.6l-.1-2.5a3.2 3.2 0 0 0-.8-1.4 2.7 2.7 0 0 0-1.2-.7 13 13 0 0 0-2.3-.3h-1.3z" fill="#fff"></path></g><g stroke-opacity=".5"><path d="m317.6 210.2 3.3-13.6 4.4 1 3.2 1c.7.4 1.3 1 1.6 1.9.4.8.4 1.7.2 2.8-.2.8-.5 1.5-1 2a3.9 3.9 0 0 1-3 1.4c-.7 0-1.7-.2-3-.5l-1.7-.5-1.2 5.2-2.8-.7z" fill="#309e3a"></path><path d="m323 199.6-.8 3.8 1.5.4c1 .2 1.8.4 2.2.3a1.9 1.9 0 0 0 1.6-1.5c0-.5 0-.9-.2-1.3a2 2 0 0 0-1-.9l-1.9-.5-1.3-.3z" fill="#fff"></path></g><g stroke-opacity=".5"><path d="m330.6 214.1 4.7-13.2 5.5 2c1.5.5 2.4 1 3 1.4.5.5.9 1 1 1.8s.2 1.5 0 2.3c-.4 1-1 1.7-1.8 2.2-.8.4-1.8.5-3 .3.4.5.8 1 1 1.6l.8 2.7.6 3.1-3.1-1.1-1-3.6a19.5 19.5 0 0 0-.7-2.4 2.1 2.1 0 0 0-.6-.8c-.2-.3-.6-.5-1.3-.7l-.5-.2-2 5.6-2.6-1z" fill="#309e3a"></path><path d="m336 207.4 1.9.7c1.3.5 2.1.7 2.5.7.3 0 .6 0 .9-.3.3-.2.5-.5.6-.9.2-.4.2-.8 0-1.2a1.7 1.7 0 0 0-.8-.9l-2-.7-2-.7-1.2 3.3z" fill="#fff"></path></g><g stroke-opacity=".5"><path d="M347 213.6a9 9 0 0 1 1.7-3.2 6.6 6.6 0 0 1 1.8-1.5 6 6 0 0 1 2-.7c1 0 2 0 3.1.4a6.5 6.5 0 0 1 4.2 3.3c.8 1.6.8 3.5.2 5.7a7.4 7.4 0 0 1-3.4 4.5c-1.5.9-3.3 1-5.2.4a6.6 6.6 0 0 1-4.2-3.3 7.3 7.3 0 0 1-.2-5.6z" fill="#309e3a"></path><path d="M349.8 214.4c-.4 1.5-.5 2.8 0 3.8s1.2 1.6 2.3 2c1 .3 2 .2 3-.4 1-.5 1.6-1.6 2.1-3.2.5-1.5.5-2.7 0-3.7a3.5 3.5 0 0 0-2.2-2 3.6 3.6 0 0 0-3 .3c-1 .6-1.7 1.6-2.2 3.2z" fill="#fff"></path></g><g stroke-opacity=".5"><path d="m374.3 233.1 6.4-12.4 5.3 2.7a10 10 0 0 1 2.7 1.9c.5.5.8 1.1.8 1.9s0 1.5-.4 2.2a3.8 3.8 0 0 1-2 2c-1 .2-2 .2-3.1-.2.4.6.6 1.2.8 1.7.2.6.3 1.5.4 2.8l.2 3.2-3-1.5-.4-3.7a20 20 0 0 0-.3-2.5 2 2 0 0 0-.5-1l-1.2-.7-.5-.3-2.7 5.2-2.5-1.3z" fill="#309e3a"></path><path d="m380.5 227.2 1.9 1c1.2.6 2 1 2.3 1 .3 0 .7 0 1-.2.3-.1.5-.4.7-.8.2-.4.3-.8.2-1.2a2 2 0 0 0-.7-1 23.7 23.7 0 0 0-1.8-1l-2-1-1.6 3.2z" fill="#fff"></path></g><g stroke-opacity=".5"><path d="M426.1 258.7a8.9 8.9 0 0 1 2.5-2.6 6.6 6.6 0 0 1 2.2-.9 5.5 5.5 0 0 1 2.2 0c1 .2 1.9.6 2.8 1.2a6.6 6.6 0 0 1 3 4.4c.3 1.7-.2 3.6-1.4 5.5a7.3 7.3 0 0 1-4.5 3.3 6.5 6.5 0 0 1-5.2-1.1 6.6 6.6 0 0 1-3-4.4c-.3-1.8.2-3.6 1.4-5.4z" fill="#309e3a"></path><path d="M428.6 260.3c-1 1.3-1.3 2.5-1.1 3.6a3.6 3.6 0 0 0 1.6 2.5c1 .7 2 .9 3 .6 1-.3 2-1 2.9-2.4.9-1.4 1.3-2.6 1.1-3.6-.1-1-.7-1.9-1.6-2.6s-2-.8-3-.5c-1 .2-2 1-3 2.4z" fill="#fff"></path></g><path d="m301.8 204.5 2.3-9.8 7.2 1.7-.3 1.6-5.3-1.2-.5 2.2 4.9 1.1-.4 1.7-4.9-1.2-.6 2.7 5.5 1.3-.4 1.6-7.5-1.7z" fill="#309e3a"></path></g></svg>
                    <p class="text-white text-base" style="font-size: 12px;">Português</p>
                    <svg data-v-1c71b597="" height="11px" viewBox="0 0 448 512" width="11px" xmlns="http://www.w3.org/2000/svg" class="angle-down"><path d="M201.4 374.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 306.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z" fill="white"></path></svg>
                   
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { useSettingStore } from '@/Stores/SettingStore.js';
    import { footerStore } from '@/Stores/FooterStore.js';
    import LanguageSelector from '@/Components/UI/LanguageSelector.vue';

    export default defineComponent({
    components: { LanguageSelector },
    data() {
        return {
        isLoading: false,
        year: new Date().getFullYear(),
        setting: null,
        expanded: false, 
        custom: null,
        };
    },
    computed: {
        footerTextMenu() {
        return footerStore.getFooterStatus(); // Corrigir o uso do getter
        },
    },
    methods: {
        toggleExpanded() {
            this.expanded = !this.expanded;
        },
        getSetting: function() {
                const _this = this;
                const settingStore = useSettingStore();
                const settingData = settingStore.setting;

                if(settingData) {
                    _this.setting = settingData;
                }
            },
    },
    created() {
        this.getSetting();
        this.custom = custom;
    },
    });
</script>

<style scoped>

</style>
