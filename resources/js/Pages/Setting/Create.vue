<template>
  <div>
    <h1>Settings</h1>

    <form @submit.prevent="submit">
      <div>
        <label for="instansi">Instansi</label>
        <input type="text" v-model="form.instansi" id="instansi" />
      </div>
      <div>
        <label for="logo">Logo URL</label>
        <input type="text" v-model="form.logo" id="logo" />
      </div>
      <div>
        <label for="address">Address</label>
        <textarea v-model="form.address" id="address"></textarea>
      </div>
      <div>
        <label for="phone">Phone</label>
        <input type="text" v-model="form.phone" id="phone" />
      </div>
      <div>
        <label for="email">Email</label>
        <input type="email" v-model="form.email" id="email" />
      </div>
      <div>
        <label for="running_text">Running Text</label>
        <textarea v-model="form.running_text" id="running_text"></textarea>
      </div>
      <div>
        <label for="video">Video URL</label>
        <input type="text" v-model="form.video" id="video" />
      </div>
      <div>
        <label for="primary">Primary Color</label>
        <input type="color" v-model="form.primary" id="primary" />
      </div>
      <div>
        <label for="secondary">Secondary Color</label>
        <input type="color" v-model="form.secondary" id="secondary" />
      </div>
      <div>
        <label for="accent">Accent Color</label>
        <input type="color" v-model="form.accent" id="accent" />
      </div>
      <div>
        <label for="background">Background Color</label>
        <input type="color" v-model="form.background" id="background" />
      </div>
      <div>
        <label for="text">Text Color</label>
        <input type="color" v-model="form.text" id="text" />
      </div>

      <button type="submit">Save</button>
    </form>
  </div>
</template>

<script>
import { useForm } from '@inertiajs/vue3'

export default {
  props: {
    setting: Object,
  },
  setup(props) {
    const form = useForm({
      instansi: props.setting?.instansi || '',
      logo: props.setting?.logo || '',
      address: props.setting?.address || '',
      phone: props.setting?.phone || '',
      email: props.setting?.email || '',
      running_text: props.setting?.running_text || '',
      video: props.setting?.video || '',
      primary: props.setting?.primary || '',
      secondary: props.setting?.secondary || '',
      accent: props.setting?.accent || '',
      background: props.setting?.background || '',
      text: props.setting?.text || '',
    });

    const submit = () => {
      form.post(route('settings.store'));
    };

    return { form, submit };
  }
};
</script>
