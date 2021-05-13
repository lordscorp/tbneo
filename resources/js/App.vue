<template>
    <div>
        <Breadcrumbs></Breadcrumbs>
        <router-view/>
    </div>
</template>

<script>
import Breadcrumbs from './components/Breadcrumbs'

export default {
    components: {
        Breadcrumbs
    }
};
</script>
