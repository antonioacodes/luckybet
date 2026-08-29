// facebook-events.js - VERSÃO FINAL com seus campos específicos

class FacebookEvents {
    constructor(pixelId) {
        this.pixelId = pixelId;
        this.isPixelLoaded = typeof fbq !== 'undefined';
        
        if (!this.isPixelLoaded) {
            console.warn('Facebook Pixel não está carregado');
            return;
        }
        
        console.log('Facebook Events Manager inicializado');
    }

    // Gerar Event ID único para deduplicação com API
    generateEventId(prefix = 'pixel') {
        return `${prefix}_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
    }

    // CAPTURAR DADOS COMPLETOS DO USUÁRIO (baseado nos seus campos)
    getUserData() {
        const userData = window.userSession || {};
        
        return {
            external_id: userData.id || null,
            email: userData.email || null,
            phone: userData.phone || null,
            first_name: userData.firstName || null,
            last_name: userData.lastName || null,
            cpf: userData.cpf || null,
            date_of_birth: userData.dateOfBirth || null, // formato: YYYYMMDD
            city: userData.city || null,        // municipio
            state: userData.state || null,      // uf
            country: userData.country || 'BR'   // Brasil sempre
        };
    }

    // FORMATAÇÃO DE TELEFONE BRASILEIRA
    formatPhoneNumber(phone) {
        if (!phone) return null;
        
        // Remove tudo que não é número
        let cleanPhone = phone.replace(/\D/g, '');
        
        // Adiciona código do país se não tiver
        if (cleanPhone.length <= 11) {
            cleanPhone = '55' + cleanPhone;
        }
        
        return cleanPhone;
    }

    // FORMATAÇÃO DE CPF
    formatCPF(cpf) {
        if (!cpf) return null;
        // Remove tudo que não é número
        return cpf.replace(/\D/g, '');
    }

    // MONTAR ADVANCED MATCHING com todos os dados disponíveis
    buildAdvancedMatching(userInfo) {
        const advancedMatching = {};
        
        if (userInfo.email) advancedMatching.em = userInfo.email;
        if (userInfo.phone) advancedMatching.ph = this.formatPhoneNumber(userInfo.phone);
        if (userInfo.first_name) advancedMatching.fn = userInfo.first_name;
        if (userInfo.last_name) advancedMatching.ln = userInfo.last_name;
        if (userInfo.cpf) advancedMatching.external_id = this.formatCPF(userInfo.cpf);
        if (userInfo.date_of_birth) advancedMatching.db = userInfo.date_of_birth;
        if (userInfo.city) advancedMatching.ct = userInfo.city;
        if (userInfo.state) advancedMatching.st = userInfo.state;
        if (userInfo.country) advancedMatching.country = userInfo.country;

        return advancedMatching;
    }

    // EVENTO COMPLETEREGISTRATION COM TODOS OS DADOS
    trackCompleteRegistration(userData = {}) {
        if (!this.isPixelLoaded) return;

        const eventId = this.generateEventId('registration');
        const userInfo = this.getUserData();
        const advancedMatching = this.buildAdvancedMatching(userInfo);

        // ENVIAR EVENTO COM ADVANCED MATCHING COMPLETO
        fbq('track', 'CompleteRegistration', {
            content_name: 'registration',
            content_category: 'account'
        }, {
            eventID: eventId,
            ...advancedMatching
        });

        console.log('CompleteRegistration tracked with advanced matching:', {
            eventId,
            dataPoints: Object.keys(advancedMatching).length,
            campos: Object.keys(advancedMatching),
            advancedMatching
        });
        
        this.saveEventId('CompleteRegistration', eventId);
    }

    // ADDTOCART COM DADOS COMPLETOS
    trackAddToCart(amount = 0, transactionId = null) {
        if (!this.isPixelLoaded) return;

        const eventId = this.generateEventId('addtocart');
        const userInfo = this.getUserData();
        const advancedMatching = this.buildAdvancedMatching(userInfo);
        
        const customData = {
            value: parseFloat(amount),
            currency: 'BRL',
            content_type: 'product',
            content_name: 'deposit'
        };

        if (transactionId) {
            customData.content_ids = [transactionId];
        }

        fbq('track', 'AddToCart', customData, {
            eventID: eventId,
            ...advancedMatching
        });

        console.log('AddToCart tracked with advanced matching:', { 
            eventId, 
            amount, 
            transactionId, 
            dataPoints: Object.keys(advancedMatching).length,
            campos: Object.keys(advancedMatching)
        });
        
        this.saveEventId('AddToCart', eventId);
    }

    // PURCHASE COM DADOS COMPLETOS  
    trackPurchase(amount = 0, transactionId = null) {
        if (!this.isPixelLoaded) return;

        const eventId = this.generateEventId('purchase');
        const userInfo = this.getUserData();
        const advancedMatching = this.buildAdvancedMatching(userInfo);
        
        const customData = {
            value: parseFloat(amount),
            currency: 'BRL',
            content_type: 'product',
            content_name: 'deposit'
        };

        if (transactionId) {
            customData.content_ids = [transactionId];
        }

        fbq('track', 'Purchase', customData, {
            eventID: eventId,
            ...advancedMatching
        });

        console.log('Purchase tracked with advanced matching:', { 
            eventId, 
            amount, 
            transactionId,
            dataPoints: Object.keys(advancedMatching).length,
            campos: Object.keys(advancedMatching)
        });
        
        this.saveEventId('Purchase', eventId);
    }

    // 5. ViewContent - Páginas específicas
    trackViewContent(contentName = 'page', contentCategory = 'website') {
        if (!this.isPixelLoaded) return;

        const userInfo = this.getUserData();
        const advancedMatching = this.buildAdvancedMatching(userInfo);

        fbq('track', 'ViewContent', {
            content_name: contentName,
            content_category: contentCategory
        }, {
            ...advancedMatching
        });

        console.log('ViewContent tracked:', { 
            contentName, 
            contentCategory,
            dataPoints: Object.keys(advancedMatching).length 
        });
    }

    // Eventos personalizados para cassino
    trackGameStart(gameName, betAmount = 0) {
        if (!this.isPixelLoaded) return;

        const userInfo = this.getUserData();
        const advancedMatching = this.buildAdvancedMatching(userInfo);

        fbq('trackCustom', 'GameStart', {
            game_name: gameName,
            bet_amount: parseFloat(betAmount),
            currency: 'BRL'
        }, {
            ...advancedMatching
        });

        console.log('GameStart tracked:', { gameName, betAmount });
    }

    trackBigWin(amount = 0, gameName = '') {
        if (!this.isPixelLoaded) return;

        const userInfo = this.getUserData();
        const advancedMatching = this.buildAdvancedMatching(userInfo);

        fbq('trackCustom', 'BigWin', {
            win_amount: parseFloat(amount),
            game_name: gameName,
            currency: 'BRL'
        }, {
            ...advancedMatching
        });

        console.log('BigWin tracked:', { amount, gameName });
    }

    // Salvar Event IDs para deduplicação
    saveEventId(eventType, eventId) {
        const eventIds = JSON.parse(localStorage.getItem('fb_event_ids') || '{}');
        eventIds[eventType] = eventIds[eventType] || [];
        eventIds[eventType].push({
            id: eventId,
            timestamp: Date.now()
        });

        eventIds[eventType] = eventIds[eventType].slice(-10);
        localStorage.setItem('fb_event_ids', JSON.stringify(eventIds));
    }
}

// Inicializar o gerenciador de eventos
window.FacebookEvents = FacebookEvents;

// Inicialização automática quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    // Substitua pelo seu Pixel ID
    const PIXEL_ID = document.querySelector('meta[name="fb-pixel-id"]')?.content || 'SEU_PIXEL_ID_AQUI';
    
    // Criar instância global
    window.fbEvents = new FacebookEvents(PIXEL_ID);
    
    // Rastrear ViewContent automático para certas páginas
    const currentPage = window.location.pathname;
    
    if (currentPage.includes('/games') || currentPage.includes('/jogos')) {
        window.fbEvents.trackViewContent('games_page', 'games');
    } else if (currentPage.includes('/deposit') || currentPage.includes('/deposito')) {
        window.fbEvents.trackViewContent('deposit_page', 'deposit');
    } else if (currentPage === '/') {
        window.fbEvents.trackViewContent('home_page', 'homepage');
    }
});