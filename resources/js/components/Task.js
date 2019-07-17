import React, { Component } from 'react'

export default class TodoList extends Component {
  render() {
    const task = this.props.data

    return (
      <li className="list-group-item">{task.body}</li>
    )
  }
}
