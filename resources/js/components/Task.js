import React, { Component } from 'react';

export default class TodoList extends Component {
  constructor (props) {
    super (props)
  }

  render() {
    const task = this.props.data

    return (
      <li className="list-group-item">{task.body}</li>
    );
  }
}
