<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <RouterLink class="navbar-brand" to="/">Vue</RouterLink>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <RouterLink to="/" class="nav-link active"
                            >{{ $t("Employees") }}
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/city" class="nav-link active"
                            >{{ $t("Cities") }}
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/state" class="nav-link active"
                            >{{ $t("States") }}
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/country" class="nav-link active"
                            >{{ $t("Countries") }}
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/language" class="nav-link active"
                            >{{ $t("Languages") }}
                        </RouterLink>
                    </li>
                </ul>
            </div>
            <div  >


                <a class="langBtn px-3 py-1 mx-1 border rounded border-dark text-dark" @click="changeLanguage('ur')">
                    Urdu
                </a>
                <a class="langBtn px-3 py-1 mx-1 border rounded border-dark text-dark" @click="changeLanguage('en')">
                    English
                </a>
            </div>
        </div>
    </nav>
</template>
<script>
import { loadLocaleMessages } from "../i18n";

export default {
    methods: {
        async changeLanguage(locale) {
            await loadLocaleMessages(locale);
        },
    },
};
</script>
<style scoped>
.langBtn{
    text-decoration: none;
    cursor: pointer;
}
</style>
