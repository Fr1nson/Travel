// База данных туров
const toursDatabase = [
    {
        id: 1,
        title: 'Мальдивы - Райский Остров',
        country: 'maldives',
        type: 'beach',
        price: 185000,
        duration: 10,
        image: 'img/mald1.jpg',
        description: 'Незабываемый отдых на белоснежных пляжах Мальдив. Проживание в роскошном отеле 5*, питание all inclusive, трансфер и экскурсии включены.',
        details: { days: '10 дней', flight: 'Прямой перелет', hotel: '5* All Inclusive' },
        departureCities: ['moscow', 'spb', 'kazan'],
        availableFrom: '2026-01-15',
        availableTo: '2026-12-20',
        resort: 'Мале',
        meal: 'ai',
        hotelStars: 5,
        maxGuests: 6
    },
    {
        id: 2,
        title: 'Швейцарские Альпы',
        country: 'switzerland',
        type: 'mountains',
        price: 245000,
        duration: 7,
        image: 'img/alps2.png',
        description: 'Горнолыжный тур в Швейцарию. Катание на лучших склонах Европы, проживание в шале, инструктор включен.',
        details: { days: '7 дней', flight: 'Ски-пасс', hotel: 'Инструктор' },
        departureCities: ['moscow', 'spb'],
        availableFrom: '2026-01-10',
        availableTo: '2026-03-20',
        resort: 'Церматт',
        meal: 'hb',
        hotelStars: 4,
        maxGuests: 5
    },
    {
        id: 3,
        title: 'Романтический Париж',
        country: 'france',
        type: 'excursion',
        price: 95000,
        duration: 5,
        image: 'img/paris3.jpg',
        description: 'Экскурсионный тур по Парижу и его окрестностям. Эйфелева башня, Лувр, Версаль. Русскоязычный гид.',
        details: { days: '5 дней', flight: '8 экскурсий', hotel: '4* Завтрак' },
        departureCities: ['moscow', 'spb', 'kazan'],
        availableFrom: '2026-02-01',
        availableTo: '2026-12-15',
        resort: 'Париж',
        meal: 'bb',
        hotelStars: 4,
        maxGuests: 6
    },
    {
        id: 4,
        title: 'Греческие Острова',
        country: 'greece',
        type: 'beach',
        price: 165000,
        duration: 8,
        image: 'img/grecOstr4.jpg',
        description: 'Круиз по островам Греции: Санторини, Миконос, Крит. Проживание на яхте, питание включено.',
        details: { days: '8 дней', flight: 'Яхта', hotel: '3 острова' },
        departureCities: ['moscow', 'spb'],
        availableFrom: '2026-04-01',
        availableTo: '2026-10-31',
        resort: 'Санторини',
        meal: 'hb',
        hotelStars: 4,
        maxGuests: 6
    },
    {
        id: 5,
        title: 'Япония - Цветение Сакуры',
        country: 'japan',
        type: 'excursion',
        price: 285000,
        duration: 12,
        image: 'img/japan5.jpg',
        description: 'Тур в Японию в период цветения сакуры. Токио, Киото, Осака. Посещение храмов и традиционных садов.',
        details: { days: '12 дней', flight: 'Сезон сакуры', hotel: '10 экскурсий' },
        departureCities: ['moscow'],
        availableFrom: '2026-03-15',
        availableTo: '2026-04-20',
        resort: 'Токио',
        meal: 'bb',
        hotelStars: 4,
        maxGuests: 5
    },
    {
        id: 6,
        title: 'Турция - Анталья',
        country: 'turkey',
        type: 'beach',
        price: 98000,
        duration: 7,
        image: 'img/turkiya.jpeg',
        description: 'Классический пляжный отдых в Анталье. Отель у моря, бассейн, питание all inclusive.',
        details: { days: '7 дней', flight: 'Регулярный рейс', hotel: '5* All Inclusive' },
        departureCities: ['moscow', 'spb', 'kazan'],
        availableFrom: '2026-04-10',
        availableTo: '2026-11-10',
        resort: 'Анталья',
        meal: 'ai',
        hotelStars: 5,
        maxGuests: 6
    },
    {
        id: 7,
        title: 'Турция - Аланья',
        country: 'turkey',
        type: 'beach',
        price: 82000,
        duration: 6,
        image: 'img/turkiya.jpeg',
        description: 'Комфортный отдых в Аланье: пляж, прогулки, удобный формат для пары или семьи.',
        details: { days: '6 дней', flight: 'Регулярный рейс', hotel: '4* HB' },
        departureCities: ['moscow', 'spb'],
        availableFrom: '2026-04-10',
        availableTo: '2026-11-15',
        resort: 'Аланья',
        meal: 'hb',
        hotelStars: 4,
        maxGuests: 6
    },
    {
        id: 8,
        title: 'Египет - Хургада',
        country: 'egypt',
        type: 'beach',
        price: 89000,
        duration: 8,
        image: 'img/bali.jpg',
        description: 'Тёплое Красное море, снорклинг и комфортные отели. Отлично для отдыха круглый год.',
        details: { days: '8 дней', flight: 'Регулярный рейс', hotel: '4* All Inclusive' },
        departureCities: ['moscow', 'kazan'],
        availableFrom: '2026-01-10',
        availableTo: '2026-12-25',
        resort: 'Хургада',
        meal: 'ai',
        hotelStars: 4,
        maxGuests: 6
    },
    {
        id: 9,
        title: 'Египет - Шарм‑эль‑Шейх',
        country: 'egypt',
        type: 'beach',
        price: 102000,
        duration: 9,
        image: 'img/bali.jpg',
        description: 'Идеально для дайвинга и пляжного отдыха. Красивые рифы и насыщенная экскурсионка.',
        details: { days: '9 дней', flight: 'Регулярный рейс', hotel: '5* All Inclusive' },
        departureCities: ['moscow', 'spb'],
        availableFrom: '2026-01-10',
        availableTo: '2026-12-25',
        resort: 'Шарм‑эль‑Шейх',
        meal: 'ai',
        hotelStars: 5,
        maxGuests: 6
    },
    {
        id: 10,
        title: 'ОАЭ - Дубай',
        country: 'uae',
        type: 'beach',
        price: 165000,
        duration: 7,
        image: 'img/4.jpg',
        description: 'Современный мегаполис и пляжи Персидского залива. Шопинг, развлечения и море.',
        details: { days: '7 дней', flight: 'Прямой рейс', hotel: '5* BB' },
        departureCities: ['moscow', 'spb', 'kazan'],
        availableFrom: '2026-01-05',
        availableTo: '2026-12-25',
        resort: 'Дубай',
        meal: 'bb',
        hotelStars: 5,
        maxGuests: 6
    },
    {
        id: 11,
        title: 'Россия - Красная Поляна',
        country: 'russia',
        type: 'mountains',
        price: 54000,
        duration: 5,
        image: 'img/kavkaz.jpg',
        description: 'Горы, термальные источники и прогулки. Отлично для короткого отдыха на выходные.',
        details: { days: '5 дней', flight: 'Перелёт + трансфер', hotel: '3* RO' },
        departureCities: ['moscow', 'spb', 'kazan'],
        availableFrom: '2026-01-10',
        availableTo: '2026-12-25',
        resort: 'Красная Поляна',
        meal: 'ro',
        hotelStars: 3,
        maxGuests: 5
    }
];

// Текущие фильтры
let currentFilters = {
    type: 'all',
    country: 'all',
    priceMin: 0,
    priceMax: 500000,
    duration: 'all'
};
let lastRenderedTours = new Map();

// Инициализация при загрузке
document.addEventListener('DOMContentLoaded', () => {
    Promise.resolve(initializePage()).catch(() => {});
});

function buildQuery(params) {
    const sp = new URLSearchParams();
    Object.entries(params || {}).forEach(([key, value]) => {
        if (value === undefined || value === null) return;
        const v = String(value).trim();
        if (!v) return;
        sp.set(key, v);
    });
    const qs = sp.toString();
    return qs ? `?${qs}` : '';
}

async function apiJson(path, options) {
    const response = await fetch(path, {
        headers: {
            'Content-Type': 'application/json'
        },
        ...options
    });
    const raw = await response.text().catch(() => '');
    const data = (() => {
        if (!raw) return null;
        try {
            return JSON.parse(raw);
        } catch {
            return null;
        }
    })();

    if (!response.ok) {
        const messageFromJson = data && typeof data === 'object' ? (data.error || '') : '';
        const message = messageFromJson || (raw ? String(raw).slice(0, 300) : `HTTP_${response.status}`);
        const err = new Error(message);
        err.status = response.status;
        err.payload = data;
        throw err;
    }

    return data;
}

function normalizeTour(tour) {
    const nights = Number(tour.nights ?? tour.duration) || 0;
    return {
        id: tour.id,
        title: tour.title,
        country: tour.country,
        type: tour.type,
        price: Number(tour.price) || 0,
        nights,
        image: tour.image,
        description: tour.description,
        resort: tour.resort || '',
        meal: tour.meal || '',
        hotelStars: Number(tour.hotel_stars ?? tour.hotelStars) || null,
        maxGuests: Number(tour.max_guests ?? tour.maxGuests) || null
    };
}

async function fetchToursFromApi(filters) {
    const data = await apiJson(`api/tours${buildQuery(filters)}`, { method: 'GET' });
    const items = Array.isArray(data?.items) ? data.items : [];
    return items.map(normalizeTour);
}

async function fetchMetadataFromApi() {
    const data = await apiJson('api/metadata', { method: 'GET' });
    return data && typeof data === 'object' ? data : null;
}

async function initializePage() {
    initializeBurgerMenu();
    initializeNewsletter();
    initializeLegalModal();
    initializeBookingModal();
    await initializeTourSearchPage();
    initializeContactForm();
    initializePreferenceButtons();

    // Инициализация страницы туров
    const toursContainer = document.getElementById('toursContainer');
    if (toursContainer) {
        const fixedType = toursContainer.getAttribute('data-tour-type');
        try {
            const filters = fixedType ? { type: fixedType } : {};
            const tours = await fetchToursFromApi(filters);
            renderTours(tours);
        } catch {
            const fallback = fixedType
                ? toursDatabase.filter(t => t.type === fixedType).map(normalizeTour)
                : toursDatabase.map(normalizeTour);
            renderTours(fallback);
        }
    }
    
    // Инициализация таймера для горящих туров
    if (document.getElementById('countdown-timer')) {
        startCountdown();
    }
    
    // Инициализация анимаций
    initializeAnimations();
    
    // Инициализация скролла хедера
    initializeHeaderScroll();

    initializePopularCarousel();
}

async function initializeTourSearchPage() {
    const root = document.querySelector('[data-tour-search]');
    if (!root) return;

    const getEl = (selector) => root.querySelector(selector);
    const countrySelect = getEl('[data-filter="country"]');
    const resortList = getEl('[data-filter="resorts"]');
    const countEl = getEl('[data-filter="count"]');

    const filterEls = {
        departure: getEl('[data-filter="departure"]'),
        country: countrySelect,
        dateFrom: getEl('[data-filter="dateFrom"]'),
        dateTo: getEl('[data-filter="dateTo"]'),
        nightsMin: getEl('[data-filter="nightsMin"]'),
        nightsMax: getEl('[data-filter="nightsMax"]'),
        adults: getEl('[data-filter="adults"]'),
        children: getEl('[data-filter="children"]'),
        meal: getEl('[data-filter="meal"]'),
        budgetMin: getEl('[data-filter="budgetMin"]'),
        budgetMax: getEl('[data-filter="budgetMax"]'),
        sort: getEl('[data-filter="sort"]'),
        starsWrap: getEl('[data-filter="stars"]'),
        reset: getEl('[data-filter="reset"]')
    };

    const countryLabels = {
        maldives: 'Мальдивы',
        switzerland: 'Швейцария',
        france: 'Франция',
        greece: 'Греция',
        japan: 'Япония',
        turkey: 'Турция',
        egypt: 'Египет',
        uae: 'ОАЭ',
        russia: 'Россия'
    };

    const departureLabels = {
        moscow: 'Москва',
        spb: 'Санкт‑Петербург',
        kazan: 'Казань'
    };

    const mealLabels = {
        ai: 'All Inclusive',
        hb: 'Half Board',
        bb: 'Breakfast',
        ro: 'Без питания'
    };

    let metadata = null;
    try {
        metadata = await fetchMetadataFromApi();
    } catch {
        metadata = null;
    }

    const metaCountries = Array.isArray(metadata?.countries)
        ? metadata.countries
        : Array.from(new Set(toursDatabase.map(t => t.country)));

    const metaDepartures = Array.isArray(metadata?.departures)
        ? metadata.departures
        : Array.from(new Set(toursDatabase.flatMap(t => t.departureCities || [])));

    if (filterEls.departure instanceof HTMLSelectElement) {
        filterEls.departure.innerHTML = [
            `<option value="all">Любой</option>`,
            ...metaDepartures.map(code => `<option value="${code}">${departureLabels[code] || code}</option>`)
        ].join('');
    }

    if (countrySelect instanceof HTMLSelectElement) {
        const sorted = [...metaCountries].sort((a, b) => (countryLabels[a] || a).localeCompare(countryLabels[b] || b, 'ru'));
        countrySelect.innerHTML = [
            `<option value="all">Любая</option>`,
            ...sorted.map(code => `<option value="${code}">${countryLabels[code] || code}</option>`)
        ].join('');
    }

    const renderResorts = () => {
        if (!resortList) return;
        const selectedCountry = (filterEls.country instanceof HTMLSelectElement) ? filterEls.country.value : 'all';
        const resorts = Array.isArray(metadata?.resorts)
            ? metadata.resorts.filter(r => selectedCountry === 'all' || r.country === selectedCountry).map(r => r.resort)
            : toursDatabase.filter(t => selectedCountry === 'all' || t.country === selectedCountry).map(t => t.resort).filter(Boolean);

        const uniqueResorts = Array.from(new Set(resorts.filter(Boolean))).sort((a, b) => a.localeCompare(b, 'ru'));
        resortList.innerHTML = uniqueResorts.length
            ? uniqueResorts.map((name) => `
                <label class="resort-option">
                    <input type="checkbox" value="${name}">
                    <span>${name}</span>
                </label>
            `).join('')
            : `<div style="color: var(--text-light); font-size: 14px;">Нет доступных курортов</div>`;
    };

    const getSelectedResorts = () => {
        if (!resortList) return new Set();
        const inputs = Array.from(resortList.querySelectorAll('input[type="checkbox"]'));
        return new Set(inputs.filter(i => i.checked).map(i => i.value));
    };

    const getSelectedStars = () => {
        const wrap = filterEls.starsWrap;
        if (!wrap) return new Set();
        const inputs = Array.from(wrap.querySelectorAll('input[type="checkbox"]'));
        return new Set(inputs.filter(i => i.checked).map(i => Number(i.value)).filter(n => Number.isFinite(n)));
    };

    const parseNumber = (value) => {
        const n = Number(value);
        return Number.isFinite(n) ? n : null;
    };

    const applyInstantFilters = async () => {
        const departure = (filterEls.departure instanceof HTMLSelectElement) ? filterEls.departure.value : 'all';
        const country = (filterEls.country instanceof HTMLSelectElement) ? filterEls.country.value : 'all';
        const dateFrom = (filterEls.dateFrom instanceof HTMLInputElement) ? filterEls.dateFrom.value : '';
        const dateTo = (filterEls.dateTo instanceof HTMLInputElement) ? filterEls.dateTo.value : '';
        const nightsMin = (filterEls.nightsMin instanceof HTMLInputElement) ? parseNumber(filterEls.nightsMin.value) : null;
        const nightsMax = (filterEls.nightsMax instanceof HTMLInputElement) ? parseNumber(filterEls.nightsMax.value) : null;
        const adults = (filterEls.adults instanceof HTMLSelectElement) ? parseNumber(filterEls.adults.value) : 2;
        const children = (filterEls.children instanceof HTMLSelectElement) ? parseNumber(filterEls.children.value) : 0;
        const meal = (filterEls.meal instanceof HTMLSelectElement) ? filterEls.meal.value : 'all';
        const budgetMin = (filterEls.budgetMin instanceof HTMLInputElement) ? parseNumber(filterEls.budgetMin.value) : null;
        const budgetMax = (filterEls.budgetMax instanceof HTMLInputElement) ? parseNumber(filterEls.budgetMax.value) : null;
        const sortMode = (filterEls.sort instanceof HTMLSelectElement) ? filterEls.sort.value : 'popular';

        const selectedResorts = getSelectedResorts();
        const selectedStars = getSelectedStars();

        const filters = {
            departure,
            country,
            dateFrom,
            dateTo,
            nightsMin: nightsMin ?? '',
            nightsMax: nightsMax ?? '',
            adults: adults ?? 2,
            children: children ?? 0,
            meal,
            budgetMin: budgetMin ?? '',
            budgetMax: budgetMax ?? '',
            sort: sortMode,
            stars: Array.from(selectedStars).join(','),
            resorts: Array.from(selectedResorts).join(',')
        };

        let tours = [];
        try {
            tours = await fetchToursFromApi(filters);
        } catch {
            tours = toursDatabase.map(normalizeTour);
        }

        renderTours(tours);

        if (countEl) {
            const noun = (n) => {
                const mod10 = n % 10;
                const mod100 = n % 100;
                if (mod10 === 1 && mod100 !== 11) return 'тур';
                if (mod10 >= 2 && mod10 <= 4 && !(mod100 >= 12 && mod100 <= 14)) return 'тура';
                return 'туров';
            };
            countEl.textContent = `${tours.length} ${noun(tours.length)}`;
        }
    };

    const bindInstant = (el) => {
        if (!el) return;
        const evt = (el instanceof HTMLInputElement && (el.type === 'number' || el.type === 'date')) ? 'input' : 'change';
        el.addEventListener(evt, () => {
            if (el === filterEls.country) {
                renderResorts();
            }
            void applyInstantFilters();
        });
    };

    Object.values(filterEls).forEach(bindInstant);

    if (resortList) {
        resortList.addEventListener('change', () => void applyInstantFilters());
    }

    if (filterEls.starsWrap) {
        filterEls.starsWrap.addEventListener('change', () => void applyInstantFilters());
    }

    if (filterEls.reset) {
        filterEls.reset.addEventListener('click', () => {
            if (filterEls.departure instanceof HTMLSelectElement) filterEls.departure.value = 'all';
            if (filterEls.country instanceof HTMLSelectElement) filterEls.country.value = 'all';
            if (filterEls.dateFrom instanceof HTMLInputElement) filterEls.dateFrom.value = '';
            if (filterEls.dateTo instanceof HTMLInputElement) filterEls.dateTo.value = '';
            if (filterEls.nightsMin instanceof HTMLInputElement) filterEls.nightsMin.value = '';
            if (filterEls.nightsMax instanceof HTMLInputElement) filterEls.nightsMax.value = '';
            if (filterEls.adults instanceof HTMLSelectElement) filterEls.adults.value = '2';
            if (filterEls.children instanceof HTMLSelectElement) filterEls.children.value = '0';
            if (filterEls.meal instanceof HTMLSelectElement) filterEls.meal.value = 'all';
            if (filterEls.budgetMin instanceof HTMLInputElement) filterEls.budgetMin.value = '';
            if (filterEls.budgetMax instanceof HTMLInputElement) filterEls.budgetMax.value = '';
            if (filterEls.sort instanceof HTMLSelectElement) filterEls.sort.value = 'popular';
            if (filterEls.starsWrap) {
                filterEls.starsWrap.querySelectorAll('input[type="checkbox"]').forEach((i) => { i.checked = false; });
            }
            renderResorts();
            void applyInstantFilters();
        });
    }

    renderResorts();
    await applyInstantFilters();

    root.querySelectorAll('[data-filter="meal"] option').forEach((opt) => {
        if (!(opt instanceof HTMLOptionElement)) return;
        const key = opt.value;
        if (mealLabels[key]) opt.textContent = mealLabels[key];
    });
}

function initializePreferenceButtons() {
    const buttons = Array.from(document.querySelectorAll('.preference-btn'));
    if (buttons.length === 0) return;

    buttons.forEach((button) => {
        if (!(button instanceof HTMLElement)) return;
        if (button.dataset.ready === 'true') return;
        button.dataset.ready = 'true';

        button.addEventListener('click', () => {
            button.classList.toggle('active');
        });
    });
}

function initializeBurgerMenu() {
    const burger = document.getElementById('burger');
    const navMenu = document.getElementById('nav-menu');
    if (!burger || !navMenu) return;

    if (burger.dataset.ready === 'true') return;
    burger.dataset.ready = 'true';

    burger.addEventListener('click', () => {
        navMenu.classList.toggle('show');
    });

    document.addEventListener('click', (event) => {
        if (!navMenu.classList.contains('show')) return;
        const target = event.target;
        if (target instanceof Node && (navMenu.contains(target) || burger.contains(target))) return;
        navMenu.classList.remove('show');
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) navMenu.classList.remove('show');
    });
}

function initializeNewsletter() {
    const forms = Array.from(document.querySelectorAll('[data-newsletter]'));
    if (forms.length === 0) return;

    forms.forEach((form) => {
        if (form.dataset.ready === 'true') return;
        form.dataset.ready = 'true';

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const emailInput = form.querySelector('input[type="email"]');
            if (!(emailInput instanceof HTMLInputElement)) return;

            if (!emailInput.checkValidity()) {
                emailInput.reportValidity();
                return;
            }

            try {
                await apiJson('api/newsletter', {
                    method: 'POST',
                    body: JSON.stringify({ email: emailInput.value })
                });
                alert('Спасибо за подписку! Мы скоро пришлём первую подборку.');
                form.reset();
            } catch {
                alert('Не удалось оформить подписку. Попробуйте ещё раз.');
            }
        });
    });
}

function initializeLegalModal() {
    const modal = document.querySelector('[data-legal-modal]');
    const content = document.querySelector('[data-legal-content]');
    if (!modal || !content) return;

    const openButtons = Array.from(document.querySelectorAll('[data-legal]'));
    const closeButtons = Array.from(document.querySelectorAll('[data-legal-close]'));

    const legalTexts = {
        privacy: {
            title: 'Политика конфиденциальности',
            paragraphs: [
                'Мы используем данные, которые вы оставляете на сайте, только для связи, подбора туров и улучшения сервиса.',
                'Контактная информация (например, email) может использоваться для отправки подборок и уведомлений, если вы дали согласие на рассылку.',
                'Мы не передаём ваши персональные данные третьим лицам, кроме случаев, когда это требуется для оформления поездки или предусмотрено законом.'
            ]
        },
        terms: {
            title: 'Условия использования',
            paragraphs: [
                'Информация на сайте носит ознакомительный характер и может обновляться без предварительного уведомления.',
                'Цены и доступность туров зависят от партнёров (отелей, авиакомпаний) и уточняются при подтверждении заявки.',
                'Используя сайт, вы соглашаетесь с правилами обработки данных и бережным использованием материалов сайта.'
            ]
        }
    };

    const closeModal = () => {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        content.innerHTML = '';
    };

    const openModal = (key) => {
        const entry = legalTexts[key];
        if (!entry) return;

        const html = [
            `<h3>${entry.title}</h3>`,
            ...entry.paragraphs.map(p => `<p>${p}</p>`)
        ].join('');

        content.innerHTML = html;
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
    };

    openButtons.forEach((button) => {
        if (!(button instanceof HTMLElement)) return;
        button.addEventListener('click', () => openModal(button.getAttribute('data-legal')));
    });

    closeButtons.forEach((button) => {
        button.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;
        if (!modal.classList.contains('is-open')) return;
        closeModal();
    });
}

function initializeBookingModal() {
    const existing = document.querySelector('[data-booking-modal]');
    if (existing) return;

    const wrapper = document.createElement('div');
    wrapper.className = 'booking-modal';
    wrapper.setAttribute('data-booking-modal', '');
    wrapper.setAttribute('aria-hidden', 'true');

    wrapper.innerHTML = `
        <div class="booking-modal__backdrop" data-booking-close></div>
        <div class="booking-modal__dialog glass-morphism" role="dialog" aria-modal="true" aria-label="Бронирование тура">
            <button class="booking-modal__close" type="button" data-booking-close aria-label="Закрыть">×</button>
            <div class="booking-modal__header">
                <div class="booking-modal__title">Бронирование тура</div>
                <div class="booking-modal__subtitle" data-booking-subtitle>Заполните форму — мы свяжемся с вами в течение 15 минут.</div>
            </div>
            <div class="booking-modal__summary" data-booking-summary></div>
            <details class="booking-template" data-booking-template>
                <summary class="booking-template__summary">Шаблон заполнения (чтобы заявка ушла в БД)</summary>
                <div class="booking-template__body">
                    <div class="booking-template__grid">
                        <div class="booking-template__item"><span class="booking-template__key">Имя:</span> Иван Иванов</div>
                        <div class="booking-template__item"><span class="booking-template__key">Телефон:</span> +79991234567</div>
                        <div class="booking-template__item"><span class="booking-template__key">Email:</span> ivan@example.com</div>
                        <div class="booking-template__item"><span class="booking-template__key">Даты:</span> 2026-02-01 → 2026-02-08</div>
                        <div class="booking-template__item"><span class="booking-template__key">Туристов:</span> 2</div>
                        <div class="booking-template__item"><span class="booking-template__key">Пожелания:</span> номер double, питание AI</div>
                    </div>
                    <div class="booking-template__actions">
                        <button class="button-secondary booking-template__fill" type="button" data-booking-fill>Заполнить пример</button>
                    </div>
                    <pre class="booking-template__code">{
  "tour_id": 6,
  "name": "Иван Иванов",
  "phone": "+79991234567",
  "email": "ivan@example.com",
  "start_date": "2026-02-01",
  "end_date": "2026-02-08",
  "guests": 2,
  "note": "номер double, питание AI"
}</pre>
                </div>
            </details>
            <form class="booking-form" data-booking-form>
                <div class="booking-form__grid">
                    <div class="booking-field">
                        <label class="booking-label">Имя</label>
                        <input class="booking-input" name="name" type="text" autocomplete="name" placeholder="Например: Иван Иванов" minlength="2" required>
                        <div class="booking-hint">Только текст. Минимум 2 символа.</div>
                    </div>
                    <div class="booking-field">
                        <label class="booking-label">Телефон</label>
                        <input class="booking-input" name="phone" type="tel" autocomplete="tel" inputmode="tel" placeholder="Например: +79991234567" pattern="^[+]?[\d\s()\-]{7,20}$" title="Пример: +79991234567" required>
                        <div class="booking-hint">Можно с +, пробелами и скобками. Лучше в формате +79991234567.</div>
                    </div>
                    <div class="booking-field booking-field--wide">
                        <label class="booking-label">Email</label>
                        <input class="booking-input" name="email" type="email" autocomplete="email" placeholder="you@example.com" required>
                        <div class="booking-hint">Пример: ivan@example.com</div>
                    </div>
                    <div class="booking-field">
                        <label class="booking-label">Дата выезда</label>
                        <input class="booking-input" name="startDate" type="date" required>
                        <div class="booking-hint">Формат: ГГГГ-ММ-ДД</div>
                    </div>
                    <div class="booking-field">
                        <label class="booking-label">Дата возвращения</label>
                        <input class="booking-input" name="endDate" type="date" required>
                        <div class="booking-hint">Формат: ГГГГ-ММ-ДД</div>
                    </div>
                    <div class="booking-field">
                        <label class="booking-label">Туристов</label>
                        <input class="booking-input" name="guests" type="number" min="1" max="20" value="2" required>
                        <div class="booking-hint">Число от 1 до 20.</div>
                    </div>
                    <div class="booking-field booking-field--wide">
                        <label class="booking-label">Пожелания</label>
                        <textarea class="booking-textarea" name="note" rows="3" placeholder="Например: тип номера, питание, бюджет, трансферы"></textarea>
                        <div class="booking-hint">Поле необязательное.</div>
                    </div>
                </div>
                <label class="booking-consent">
                    <input class="booking-consent__input" type="checkbox" required>
                    <span>Согласен(на) на обработку персональных данных</span>
                </label>
                <div class="booking-actions">
                    <button class="button-secondary booking-actions__secondary" type="button" data-booking-close>Отмена</button>
                    <button class="cta-button booking-actions__primary" type="submit">Отправить заявку</button>
                </div>
            </form>
        </div>
    `;

    document.body.appendChild(wrapper);

    const closeButtons = Array.from(wrapper.querySelectorAll('[data-booking-close]'));
    const form = wrapper.querySelector('[data-booking-form]');
    const summary = wrapper.querySelector('[data-booking-summary]');
    const subtitle = wrapper.querySelector('[data-booking-subtitle]');
    const fillButton = wrapper.querySelector('[data-booking-fill]');
    let currentTour = null;

    const pad2 = (value) => String(value).padStart(2, '0');
    const formatDate = (date) => `${date.getFullYear()}-${pad2(date.getMonth() + 1)}-${pad2(date.getDate())}`;
    const addDays = (date, days) => new Date(date.getFullYear(), date.getMonth(), date.getDate() + days);

    const setDefaultsIfEmpty = () => {
        if (!(form instanceof HTMLFormElement)) return;
        const startInput = form.querySelector('input[name="startDate"]');
        const endInput = form.querySelector('input[name="endDate"]');
        if (!(startInput instanceof HTMLInputElement) || !(endInput instanceof HTMLInputElement)) return;

        const today = new Date();
        const todayValue = formatDate(today);
        startInput.min = todayValue;
        endInput.min = todayValue;

        if (!startInput.value) startInput.value = formatDate(addDays(today, 14));
        if (!endInput.value) endInput.value = formatDate(addDays(today, 21));
        if (endInput.value < startInput.value) endInput.value = startInput.value;
        endInput.min = startInput.value;
    };

    const closeModal = () => {
        currentTour = null;
        wrapper.classList.remove('is-open');
        wrapper.setAttribute('aria-hidden', 'true');
        if (summary) summary.innerHTML = '';
        if (subtitle) subtitle.textContent = 'Заполните форму — мы свяжемся с вами в течение 15 минут.';
        if (form instanceof HTMLFormElement) {
            const endInput = form.querySelector('input[name="endDate"]');
            if (endInput instanceof HTMLInputElement) endInput.setCustomValidity('');
            form.reset();
        }
    };

    closeButtons.forEach((button) => {
        button.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;
        if (!wrapper.classList.contains('is-open')) return;
        closeModal();
    });

    const openModal = (tour) => {
        currentTour = tour && typeof tour === 'object' ? tour : null;
        if (tour && subtitle) {
            subtitle.textContent = 'Мы уточним детали и подтвердим бронирование.';
        }

        if (summary) {
            if (tour) {
                summary.innerHTML = `
                    <div class="booking-summary__name">${tour.title}</div>
                    <div class="booking-summary__price">от ${tour.price.toLocaleString('ru-RU')} ₽</div>
                `;
            } else {
                summary.innerHTML = `
                    <div class="booking-summary__name">Подбор тура</div>
                    <div class="booking-summary__price">Ответим быстро</div>
                `;
            }
        }

        wrapper.classList.add('is-open');
        wrapper.setAttribute('aria-hidden', 'false');

        setDefaultsIfEmpty();

        const firstInput = wrapper.querySelector('input[name="name"]');
        if (firstInput instanceof HTMLInputElement) firstInput.focus();
    };

    window.openBookingModal = openModal;

    if (fillButton instanceof HTMLButtonElement) {
        fillButton.addEventListener('click', () => {
            if (!(form instanceof HTMLFormElement)) return;
            const name = form.querySelector('input[name="name"]');
            const phone = form.querySelector('input[name="phone"]');
            const email = form.querySelector('input[name="email"]');
            const guests = form.querySelector('input[name="guests"]');
            const note = form.querySelector('textarea[name="note"]');
            const startInput = form.querySelector('input[name="startDate"]');
            const endInput = form.querySelector('input[name="endDate"]');

            if (name instanceof HTMLInputElement) name.value = 'Иван Иванов';
            if (phone instanceof HTMLInputElement) phone.value = '+79991234567';
            if (email instanceof HTMLInputElement) email.value = 'ivan@example.com';
            if (guests instanceof HTMLInputElement) guests.value = '2';
            if (note instanceof HTMLTextAreaElement) note.value = 'номер double, питание AI';

            const today = new Date();
            if (startInput instanceof HTMLInputElement) startInput.value = formatDate(addDays(today, 14));
            if (endInput instanceof HTMLInputElement) endInput.value = formatDate(addDays(today, 21));
            setDefaultsIfEmpty();
        });
    }

    if (form instanceof HTMLFormElement) {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const startInput = form.querySelector('input[name="startDate"]');
            const endInput = form.querySelector('input[name="endDate"]');
            if (startInput instanceof HTMLInputElement && endInput instanceof HTMLInputElement) {
                endInput.min = startInput.value || endInput.min;
                if (startInput.value && endInput.value && endInput.value < startInput.value) {
                    endInput.setCustomValidity('Дата возвращения не может быть раньше даты выезда');
                } else {
                    endInput.setCustomValidity('');
                }
            }

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const payload = {
                tour_id: currentTour && currentTour.id ? currentTour.id : null,
                name: form.querySelector('input[name="name"]')?.value || '',
                phone: form.querySelector('input[name="phone"]')?.value || '',
                email: form.querySelector('input[name="email"]')?.value || '',
                start_date: form.querySelector('input[name="startDate"]')?.value || '',
                end_date: form.querySelector('input[name="endDate"]')?.value || '',
                guests: Number(form.querySelector('input[name="guests"]')?.value || 0),
                note: form.querySelector('textarea[name="note"]')?.value || ''
            };

            try {
                await apiJson('api/bookings', {
                    method: 'POST',
                    body: JSON.stringify(payload)
                });
                alert('Заявка отправлена! Менеджер свяжется с вами в течение 15 минут.');
                closeModal();
            } catch (err) {
                const code = err && typeof err === 'object' && 'message' in err ? String(err.message) : 'request_failed';
                const hint = code === 'db_connect_error' || code === 'db_migration_error'
                    ? 'Сервер не настроен. Открой /setup.php и запусти установку, затем попробуй ещё раз.'
                    : 'Проверьте данные и попробуйте ещё раз.';
                alert(`Не удалось отправить заявку (${code}). ${hint}`);
            }
        });
    }
}

function initializeContactForm() {
    const form = document.querySelector('[data-contact-form]');
    if (!(form instanceof HTMLFormElement)) return;
    if (form.dataset.ready === 'true') return;
    form.dataset.ready = 'true';

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const payload = {
            name: form.querySelector('input[name="name"]')?.value || '',
            email: form.querySelector('input[name="email"]')?.value || '',
            phone: form.querySelector('input[name="phone"]')?.value || '',
            message: form.querySelector('textarea[name="message"]')?.value || ''
        };

        try {
            await apiJson('api/contact', {
                method: 'POST',
                body: JSON.stringify(payload)
            });
            alert('Сообщение отправлено! Мы ответим вам в ближайшее время.');
            form.reset();
        } catch {
            alert('Не удалось отправить сообщение. Попробуйте ещё раз.');
        }
    });
}

// Отображение туров
function renderTours(tours = toursDatabase) {
    const container = document.getElementById('toursContainer');
    if (!container) return;
    
    if (tours.length === 0) {
        container.innerHTML = `
            <div class="no-tours-found">
                <div style="font-size: 64px; margin-bottom: 20px;">😔</div>
                <h3 style="font-size: 28px; color: var(--text-dark); margin-bottom: 15px;">Туры не найдены</h3>
                <p style="color: var(--text-light); font-size: 18px; margin-bottom: 30px;">Попробуйте изменить параметры фильтрации</p>
                <button class="cta-button" onclick="resetFilters()">Сбросить фильтры</button>
            </div>
        `;
        return;
    }

    const mealLabels = {
        ai: 'All Inclusive',
        hb: 'Half Board',
        bb: 'Breakfast',
        ro: 'Без питания'
    };

    const stars = (count) => {
        const n = Number(count) || 0;
        return n >= 3 ? `${'★'.repeat(n)}${'☆'.repeat(Math.max(0, 5 - n))}` : '';
    };

    const nightsLabel = (n) => {
        const nights = Number(n) || 0;
        if (!nights) return '';
        const mod10 = nights % 10;
        const mod100 = nights % 100;
        let noun = 'ночей';
        if (mod10 === 1 && mod100 !== 11) noun = 'ночь';
        else if (mod10 >= 2 && mod10 <= 4 && !(mod100 >= 12 && mod100 <= 14)) noun = 'ночи';
        return `${nights} ${noun}`;
    };

    const normalized = tours.map(normalizeTour);
    lastRenderedTours = new Map(normalized.map(t => [t.id, t]));

    container.innerHTML = normalized.map(tour => {
        const details = [
            tour.nights ? `📅 ${nightsLabel(tour.nights)}` : '',
            tour.resort ? `📍 ${tour.resort}` : '',
            tour.meal ? `🍽 ${mealLabels[tour.meal] || tour.meal}` : '',
            tour.hotelStars ? `${stars(tour.hotelStars)}` : ''
        ].filter(Boolean);

        return `
        <div class="tour-card neomorphism fade-in">
            <img src="${tour.image}" alt="${tour.title}">
            <div class="tour-info">
                <div>
                    <div class="tour-title">${tour.title}</div>
                    <div class="tour-description">${tour.description}</div>
                    <div class="tour-details">
                        ${details.map(text => `<div class="tour-detail">${text}</div>`).join('')}
                    </div>
                </div>
                <div class="price-section">
                    <div class="price">${tour.price.toLocaleString('ru-RU')} ₽</div>
                    <button class="cta-button" onclick="bookTour(${tour.id})">Забронировать</button>
                </div>
            </div>
        </div>
        `;
    }).join('');
}

// Применение фильтров
function applyFilters() {
    const type = document.getElementById('tourType')?.value || 'all';
    const country = document.getElementById('country')?.value || 'all';
    const priceMin = parseInt(document.getElementById('priceMin')?.value) || 0;
    const priceMax = parseInt(document.getElementById('priceMax')?.value) || 500000;
    const duration = document.getElementById('duration')?.value || 'all';

    const filteredTours = toursDatabase.filter(tour => {
        // Фильтр по типу
        if (type !== 'all' && tour.type !== type) return false;
        
        // Фильтр по стране
        if (country !== 'all' && tour.country !== country) return false;
        
        // Фильтр по цене
        if (tour.price < priceMin || tour.price > priceMax) return false;
        
        // Фильтр по длительности
        if (duration !== 'all') {
            if (duration === '3-5' && (tour.duration < 3 || tour.duration > 5)) return false;
            if (duration === '6-10' && (tour.duration < 6 || tour.duration > 10)) return false;
            if (duration === '11-14' && (tour.duration < 11 || tour.duration > 14)) return false;
            if (duration === '15+' && tour.duration < 15) return false;
        }
        
        return true;
    });

    renderTours(filteredTours);
}

// Сброс фильтров
function resetFilters() {
    if (document.getElementById('tourType')) document.getElementById('tourType').value = 'all';
    if (document.getElementById('country')) document.getElementById('country').value = 'all';
    if (document.getElementById('priceMin')) document.getElementById('priceMin').value = '0';
    if (document.getElementById('priceMax')) document.getElementById('priceMax').value = '500000';
    if (document.getElementById('duration')) document.getElementById('duration').value = 'all';
    
    renderTours(toursDatabase);
}

// Быстрая фильтрация по типу тура
function filterTours(type) {
    if (document.getElementById('tourType')) {
        document.getElementById('tourType').value = type;
        applyFilters();
    }
}

// Бронирование тура
function bookTour(tourId) {
    const tour = lastRenderedTours.get(tourId) || toursDatabase.find(t => t.id === tourId);
    const openBookingModal = window.openBookingModal;
    if (tour && typeof openBookingModal === 'function') {
        openBookingModal(tour);
        return;
    }
    if (tour) {
        alert(`Вы выбрали тур:\n\n${tour.title}\nЦена: ${tour.price.toLocaleString('ru-RU')} ₽`);
    }
}

// Модальное окно бронирования
function showBookingModal() {
    const openBookingModal = window.openBookingModal;
    if (typeof openBookingModal === 'function') {
        openBookingModal(null);
        return;
    }
    alert('Оставьте заявку — менеджер свяжется с вами в течение 15 минут.');
}

// Таймер обратного отсчета
function startCountdown() {
    const countdownDate = new Date();
    countdownDate.setDate(countdownDate.getDate() + 5); // 5 дней от текущей даты
    
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = countdownDate - now;
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        const timerElement = document.getElementById('countdown-timer');
        if (timerElement) {
            timerElement.textContent = `${days}д ${hours}ч ${minutes}м ${seconds}с`;
        }
        
        if (distance < 0) {
            if (timerElement) {
                timerElement.textContent = "Предложение истекло!";
            }
        }
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);
}

// Личный кабинет - переключение разделов
function showProfileSection(sectionId) {
    // Скрыть все разделы
    document.querySelectorAll('.profile-section').forEach(section => {
        section.style.display = 'none';
    });
    
    // Показать выбранный раздел
    const activeSection = document.getElementById('profile-' + sectionId);
    if (activeSection) {
        activeSection.style.display = 'block';
    }
    
    // Обновить активный пункт меню
    document.querySelectorAll('.profile-menu li').forEach(item => {
        item.classList.remove('active');
    });
    event.target.classList.add('active');
}

// Инициализация анимаций
function initializeAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Наблюдаем за карточками
    document.querySelectorAll('.destination-card, .tour-card, .slide, .carousel-slide, .team-member').forEach(element => {
        observer.observe(element);
    });
}

// Скролл хедера
function initializeHeaderScroll() {
    window.addEventListener('scroll', () => {
        const header = document.getElementById('header');
        if (header) {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
    });
}

// Динамическое изменение фона по времени суток
function updateBackgroundByTime() {
    const hour = new Date().getHours();
    const body = document.body;
    
    if (hour >= 6 && hour < 12) {
        body.style.background = 'linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 50%, #90CAF9 100%)';
    } else if (hour >= 12 && hour < 18) {
        body.style.background = 'linear-gradient(135deg, #B3E5FC 0%, #81D4FA 50%, #4FC3F7 100%)';
    } else if (hour >= 18 && hour < 22) {
        body.style.background = 'linear-gradient(135deg, #90CAF9 0%, #64B5F6 50%, #42A5F5 100%)';
    } else {
        body.style.background = 'linear-gradient(135deg, #64B5F6 0%, #42A5F5 50%, #2196F3 100%)';
    }
}

// Приветствие пользователя
function greetUser() {
    const hour = new Date().getHours();
    let greeting = '';
    
    if (hour >= 5 && hour < 12) {
        greeting = 'Доброе утро';
    } else if (hour >= 12 && hour < 17) {
        greeting = 'Добрый день';
    } else if (hour >= 17 && hour < 23) {
        greeting = 'Добрый вечер';
    } else {
        greeting = 'Доброй ночи';
    }
    
    console.log(`${greeting}! Добро пожаловать на сайт TRAVEL. Приятного путешествия!`);
}

// Автопрокрутка слайдера
function initializeSlider() {
    const slider = document.querySelector('.slider');
    if (slider) {
        let isScrolling = false;
        let scrollDirection = 1;

        function autoScroll() {
            if (!isScrolling) {
                const maxScroll = slider.scrollWidth - slider.clientWidth;
                
                if (slider.scrollLeft >= maxScroll - 10) {
                    scrollDirection = -1;
                } else if (slider.scrollLeft <= 10) {
                    scrollDirection = 1;
                }
                
                slider.scrollLeft += scrollDirection * 2;
            }
        }

        slider.addEventListener('mouseenter', () => {
            isScrolling = true;
        });

        slider.addEventListener('mouseleave', () => {
            isScrolling = false;
        });

        setInterval(autoScroll, 50);
    }
}

function initializePopularCarousel() {
    const root = document.querySelector('[data-carousel="popular"]');
    if (!root) return;
    if (root.dataset.ready === 'true') return;
    root.dataset.ready = 'true';

    const viewport = root.querySelector('.carousel-viewport');
    const slides = Array.from(root.querySelectorAll('.carousel-slide'));
    const prevButton = root.querySelector('.carousel-arrow--prev');
    const nextButton = root.querySelector('.carousel-arrow--next');
    const dotsContainer = root.querySelector('.carousel-dots');

    if (!viewport || slides.length === 0 || !prevButton || !nextButton || !dotsContainer) return;

    let slidePositions = [];
    let activeIndex = 0;
    let autoplayTimer = null;
    let scrollRaf = 0;

    const wrapIndex = (index) => {
        if (slides.length === 0) return 0;
        const normalized = index % slides.length;
        return normalized < 0 ? normalized + slides.length : normalized;
    };

    const computePositions = () => {
        slidePositions = slides.map(slide => slide.offsetLeft);
    };

    const setActive = (index) => {
        activeIndex = wrapIndex(index);
        slides.forEach((slide, slideIndex) => {
            slide.classList.toggle('is-active', slideIndex === activeIndex);
        });
        Array.from(dotsContainer.children).forEach((dot, dotIndex) => {
            dot.classList.toggle('is-active', dotIndex === activeIndex);
            dot.setAttribute('aria-current', dotIndex === activeIndex ? 'true' : 'false');
        });
    };

    const scrollToIndex = (index, behavior = 'smooth') => {
        const nextIndex = wrapIndex(index);
        const targetLeft = slidePositions[nextIndex] ?? 0;
        viewport.scrollTo({ left: targetLeft, behavior });
        setActive(nextIndex);
    };

    const getClosestIndex = () => {
        if (slidePositions.length === 0) return 0;
        const currentLeft = viewport.scrollLeft;
        let bestIndex = 0;
        let bestDistance = Infinity;
        for (let i = 0; i < slidePositions.length; i += 1) {
            const distance = Math.abs(slidePositions[i] - currentLeft);
            if (distance < bestDistance) {
                bestDistance = distance;
                bestIndex = i;
            }
        }
        return bestIndex;
    };

    const buildDots = () => {
        dotsContainer.innerHTML = '';
        slides.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'carousel-dot';
            dot.setAttribute('aria-label', `Перейти к слайду ${index + 1}`);
            dot.addEventListener('click', () => scrollToIndex(index));
            dotsContainer.appendChild(dot);
        });
    };

    const stopAutoplay = () => {
        if (autoplayTimer) {
            clearInterval(autoplayTimer);
            autoplayTimer = null;
        }
    };

    const startAutoplay = () => {
        stopAutoplay();
        autoplayTimer = setInterval(() => {
            scrollToIndex(activeIndex + 1);
        }, 4500);
    };

    prevButton.addEventListener('click', () => scrollToIndex(activeIndex - 1));
    nextButton.addEventListener('click', () => scrollToIndex(activeIndex + 1));

    viewport.addEventListener('scroll', () => {
        if (scrollRaf) return;
        scrollRaf = requestAnimationFrame(() => {
            scrollRaf = 0;
            setActive(getClosestIndex());
        });
    });

    viewport.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') {
            event.preventDefault();
            scrollToIndex(activeIndex - 1);
        } else if (event.key === 'ArrowRight') {
            event.preventDefault();
            scrollToIndex(activeIndex + 1);
        }
    });

    root.addEventListener('pointerenter', stopAutoplay);
    root.addEventListener('pointerleave', startAutoplay);
    root.addEventListener('focusin', stopAutoplay);
    root.addEventListener('focusout', startAutoplay);

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) stopAutoplay();
        else startAutoplay();
    });

    root.addEventListener('click', (event) => {
        const slide = event.target.closest('.carousel-slide');
        if (!slide || !root.contains(slide)) return;
        const link = slide.getAttribute('data-link');
        if (link) window.location.href = link;
    });

    buildDots();
    computePositions();
    setActive(0);
    scrollToIndex(0, 'auto');
    startAutoplay();

    window.addEventListener('resize', () => {
        computePositions();
        scrollToIndex(activeIndex, 'auto');
    });
}

// Вызов функций при загрузке
updateBackgroundByTime();
greetUser();

// Обновление фона каждую минуту
setInterval(updateBackgroundByTime, 60000);
