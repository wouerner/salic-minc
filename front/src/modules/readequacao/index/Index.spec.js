import Vue from 'vue';
import App from './Index.vue';

describe('Index.vue', () => {
  let cmp, vm;

  beforeEach(() => {
    console.log(App);
    cmp = Vue.extend(App) // Create a copy of the original component
    vm = new cmp({
      data: { // Replace data value with this fake data
        messages: ['Cat']
      }
    }).$mount() // Instances and mounts the component
  });

  it('equals messages to ["Cat"]', () => {
    expect(vm.messages).toEqual(['Cat'])
  });

  it('has the expected html structure', () => {
    expect(cmp.element).toMatchSnapshot()
  });
});

