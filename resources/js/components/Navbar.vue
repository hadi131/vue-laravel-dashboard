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
                            >Employees
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/city" class="nav-link active"
                            >Cities
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/state" class="nav-link active"
                            >States
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/country" class="nav-link active"
                            >Countries
                        </RouterLink>
                    </li>
                 






















                </ul>

            </div>
        </div>
    </nav>
</template>
<script>
export default {};
</script>
