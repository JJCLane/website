title: "Rendering data attributes on a React functional component"
author: "Jordan Lane"
---

Today I needed to allow arbitrary data attributes to be set on functional React elements, and as I couldn't find a result I thought I'd leave this here in case it helps anyone else.

---more---

I know that ideally that the props should be specified, however in the case of a design system, we don't know exactly what data attributes the consumer may need to use. 

~~~javascript
/**
 * Return all data attributes from object
 * @param {object} props The React props containing 0 or more data properties
 * @returns {object}
 */
export function getDataAttributes(props) {
  return Object.keys(props)
    .filter((key) => key.indexOf('data-') === 0)
    .reduce((obj, key) => {
      const newObj = obj;
      newObj[key] = props[key];
      return newObj;
    }, {});
}
~~~

What it looks like to use it:

~~~jsx
function MyComponent(props) {
    const dataProps = getDataAttributes(props);
    return (
        <button {...dataProps}>My Button</button>
    );
}
~~~

~~~jsx
<MyComponent data-component-id="unique-value">
~~~

Until next time!
