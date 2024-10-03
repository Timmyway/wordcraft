// TwCollapse.spec.ts
import { mount } from '@vue/test-utils';
import TwCollapse from '@/components/TwCollapse.vue';
import { describe, it, expect } from 'vitest';

describe('TwCollapse.vue', () => {
  const defaultProps = {
    isOpen: { content: false },
    viewSection: { content: true },
    title: 'Test Collapse',
    sections: ['content'],
    hasHeader: true,
    hasPreheader: true,
  };

  it('renders the component with default props', () => {
    const wrapper = mount(TwCollapse, {
      props: defaultProps,
    });

    expect(wrapper.text()).toContain('Test Collapse');
  });

  it('toggles section on title click', async () => {
    const wrapper = mount(TwCollapse, {
      props: {
        ...defaultProps,
        isOpen: { content: false },
      },
    });

    // Verify the section is initially collapsed
    expect(wrapper.find('.tw-collapse__content').exists()).toBe(false);

    // Simulate clicking the title to expand the section
    await wrapper.find('h3').trigger('click');
    expect(wrapper.find('.tw-collapse__content').exists()).toBe(true);
  });

  it('closes an open section when clicked again', async () => {
    const wrapper = mount(TwCollapse, {
      props: {
        ...defaultProps,
        isOpen: { content: true },
      },
    });

    // Verify the section is initially expanded
    expect(wrapper.find('.tw-collapse__content').exists()).toBe(true);

    // Simulate clicking the title to collapse the section
    await wrapper.find('h3').trigger('click');
    expect(wrapper.find('.tw-collapse__content').exists()).toBe(false);
  });

  it('renders the header and preheader slots when provided', () => {
    const wrapper = mount(TwCollapse, {
      props: defaultProps,
      slots: {
        header: '<div class="header-slot">Header Content</div>',
        preheader: '<div class="preheader-slot">Preheader Content</div>',
      },
    });

    expect(wrapper.find('.header-slot').exists()).toBe(true);
    expect(wrapper.find('.preheader-slot').exists()).toBe(true);
  });

  it('renders the correct icons for expanded and collapsed states', async () => {
    const wrapper = mount(TwCollapse, {
      props: {
        ...defaultProps,
        isOpen: { content: false },
      },
    });

    // Initially, it should render the collapse icon
    expect(wrapper.find('i').classes()).toContain('fa-caret-right');

    // Click to expand the section
    await wrapper.find('h3').trigger('click');
    expect(wrapper.find('i').classes()).toContain('fa-caret-down');
  });

  it('applies custom styles for title and content height', () => {
    const wrapper = mount(TwCollapse, {
      props: {
        ...defaultProps,
        titleSize: '2rem',
        contentMaxHeight: '500px',
      },
    });

    expect(wrapper.find('h3').element.style.fontSize).toBe('2rem');
    expect(wrapper.find('.tw-collapse__content').element.style.maxHeight).toBe('500px');
  });
});
