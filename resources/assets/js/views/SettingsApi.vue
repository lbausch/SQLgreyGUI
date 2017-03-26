<template>
    <div>
        <div class="card">
            <div class="card-header"><strong>OAuth Clients</strong></div>
            <div class="card-block">
                <passport-clients></passport-clients>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><strong>Authorized Applications</strong></div>
            <div class="card-block">
                <passport-authorized-clients></passport-authorized-clients>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><strong>Personal Access Tokens</strong></div>
            <div class="card-block">
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
    </div>
</template>

<script>
    import passportClients from '../components/passport/Clients.vue'
    import passportAuthorizedClients from '../components/passport/AuthorizedClients.vue'
    import passportPersonalAccessTokens from '../components/passport/PersonalAccessTokens.vue'

    export default {
        name: 'settings-api',
        components: {
            passportClients,
            passportAuthorizedClients,
            passportPersonalAccessTokens,
        }
    }
</script>
