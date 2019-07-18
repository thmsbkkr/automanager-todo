import React, { Component } from 'react'

export default class Task extends Component {
  render() {
    const task = this.props.data

    return (
      <li className="list-group-item">
        <div className="d-flex align-items-center justify-content-between">
          <div>{task.body}</div>

          <div>
            <input type="checkbox" value="" />
          </div>
        </div>
      </li>
    )
  }
}
