export default {
  items: [
    {
      name: 'Dashboard',
      url: '/dashboard',
      icon: 'fa fa-dashboard',
    },
    {
      name: 'Greylist',
      url: '/greylist',
      icon: 'fa fa-clock-o'
    },
    {
      name: 'Auto-Whitelist',
      url: '/whitelist',
      icon: 'fa fa-thumbs-up',
      children: [
        {
          name: 'Emails',
          url: '/whitelist/emails',
          icon: 'fa fa-envelope'
        },
        {
          name: 'Domains',
          url: '/whitelist/domains',
          icon: 'fa fa-globe'
        },
      ]
    },
    {
      name: 'Opt-In',
      url: '/optin',
      icon: 'fa fa-minus-square',
      children: [
        {
          name: 'Emails',
          url: '/optin/emails',
          icon: 'fa fa-envelope'
        },
        {
          name: 'Domains',
          url: '/optin/domains',
          icon: 'fa fa-globe'
        },
      ]
    },
    {
      name: 'Opt-Out',
      url: '/optout',
      icon: 'fa fa-plus-square',
      children: [
        {
          name: 'Emails',
          url: '/optout/emails',
          icon: 'fa fa-envelope'
        },
        {
          name: 'Domains',
          url: '/optout/domains',
          icon: 'fa fa-globe'
        },
      ]
    }

  ]
}
